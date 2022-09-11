<?php namespace Monolith\WebRouting;

use Throwable;
use Monolith\Collections\Dictionary;
use Monolith\Http\{Request, Response};
use Monolith\DependencyInjection\Container;

final class RouteDispatcher
{
    private Container $container;

    public function __construct(
        Container $container
    ) {
        $this->container = $container;
    }

    // here be dragons
    public function dispatch(
        MatchedRoute $route,
        Request $request
    ): Response {
        // build the execution stack.. the controller wrapped by middlewares
        // this can all be abstracted into a single plug-like system. but this
        // is where we are right now
        $stack = $this->buildExecutionStack($route, $request);

        // match route parameters like {id} and enrich the request with the
        // parsed values
        $request = $this->enrichRequestWithRouteParameters($route, $request);

        $this->container->singleton(Request::class, $request);

        // dispatch request to stack
        return $stack($request);
    }

    private function makeController(string $controllerClass): object
    {
        try {
            return $this->container->get($controllerClass);
        } catch (Throwable $e) {
            throw CanNotDispatchRoute::unableToResolveControllerClass(
                $controllerClass
            );
        }
    }

    private function buildExecutionStack(
        MatchedRoute $route,
        Request $request
    ): mixed {
        $delegates = $this->addMiddlewareDelegates($route);
        $delegates = $this->addControllerDelegate($route, $delegates);

        return $this->stackDelegates($request, $delegates);
    }

    private function addControllerDelegate(
        MatchedRoute $route,
        $delegates
    ): array {
        $delegates[] = function (Request $request) use ($route) {
            $controller = $this->makeController($route->controllerClass());
            return $controller->{$route->controllerMethod()}($request);
        };

        return $delegates;
    }

    private function addMiddlewareDelegates(
        MatchedRoute $route
    ): array {
        return $route
            ->middlewares()
            ->map(
                fn($middlewareClass) => function (callable $next) use ($middlewareClass) {
                    $middleware = $this->container->get($middlewareClass);

                    return function (Request $request) use ($middleware, $next) {
                        return $middleware->process($request, $next);
                    };
                }
            )->toArray();
    }

    private function stackDelegates(
        Request $request,
        $delegates
    ): mixed {
        $delegates = array_reverse($delegates);

        return array_reduce(
            $delegates,
            fn($next, $delegate) => is_null($next)
                ? $delegate
                : $delegate(
                    $next ?: $request
                )
        );
    }

    private function enrichRequestWithRouteParameters(
        MatchedRoute $route,
        Request $request
    ): Request {
        return $request
            ->addAppParameters(
                Dictionary::of($route->parameters()->toArray())
            )
            ->addAppParameters(
                Dictionary::of(
                    UriParameterParser::parseUriParameters($request->uri(), $route->regex())
                )
            );
    }
}