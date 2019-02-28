<?php namespace Monolith\WebRouting;

use Monolith\Collections\Map;
use Monolith\DependencyInjection\Container;
use Monolith\Http\{Request, Response};

final class RouteDispatcher
{
    /** @var Container */
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    // here be dragons
    public function dispatch(MatchedRoute $route, Request $request): Response
    {
        // build the execution stack.. the controller wrapped by middlewares
        // this can all be abstracted into a single plug-like system. but this
        // is where we are right now
        $stack = $this->buildExecutionStack($route, $request);

        // match route parameters like {id} and enrich the request with the
        // parsed values
        $request = $this->enrichRequestWithRouteParameters($route, $request);

        // dispatch request to stack
        return $stack($request);
    }

    private function makeController(string $controller)
    {
        try {
            return $this->container->get($controller);
        } catch (\Exception $e) {
            throw new CanNotResolveControllerForRouting($e->getMessage());
        }
    }

    /**
     * @param MatchedRoute $route
     * @param Request $request
     * @return mixed
     */
    private function buildExecutionStack(MatchedRoute $route, Request $request)
    {
        $delegates = $this->addMiddlewareDelegates($route);
        $delegates = $this->addControllerDelegate($route, $delegates);

        return $this->stackDelegates($request, $delegates);
    }

    /**
     * @param MatchedRoute $route
     * @param $delegates
     * @return array
     */
    private function addControllerDelegate(MatchedRoute $route, $delegates): array
    {
        $delegates[] = function (Request $request) use ($route) {
            $controller = $this->makeController($route->controllerClass());
            return $controller->{$route->controllerMethod()}($request);
        };

        return $delegates;
    }

    /**
     * @param MatchedRoute $route
     * @return array
     */
    private function addMiddlewareDelegates(MatchedRoute $route): array
    {
        return $route->middlewares()->map(function ($middlewareClass) {
            return function (callable $next) use ($middlewareClass) {
                $middleware = $this->container->get($middlewareClass);

                return function (Request $request) use ($middleware, $next) {
                    return $middleware->process($request, $next);
                };
            };
        })->toArray();
    }

    /**
     * @param Request $request
     * @param $delegates
     * @return mixed
     */
    private function stackDelegates(Request $request, $delegates)
    {
        $delegates = array_reverse($delegates);

        return array_reduce($delegates, function ($next, $delegate) use ($request) {
            if ($next == null) {
                return $delegate;
            }

            return $delegate($next ?: $request);
        });
    }

    /**
     * @param MatchedRoute $route
     * @param Request $request
     * @return Request
     */
    private function enrichRequestWithRouteParameters(MatchedRoute $route, Request $request): Request
    {
        $parameters = UriParameterParser::parseUriParameters($request->uri(), $route->regex());
        $request = $request
            ->addParameters(new Map($route->parameters()->toArray()))
            ->addParameters(new Map($parameters));
        return $request;
    }
}