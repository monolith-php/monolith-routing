<?php namespace Monolith\WebRouting;

use Monolith\DependencyInjection\Container;
use Monolith\Http\{Request, Response};

final class RouteDispatcher {

    /** @var Container */
    private $container;

    public function __construct(Container $container) {

        $this->container = $container;
    }

    // here be dragons
    public function dispatch(MatchedRoute $route, Request $request): Response {

        $stack = $this->buildExecutionStack($route, $request);

        return $stack($request);
    }

    private function makeController(string $controller) {

        try {
            return $this->container->get($controller);
        } catch (\Exception $e) {
            throw new CanNotResolveControllerForRouting($controller);
        }
    }

    /**
     * @param MatchedRoute $route
     * @param Request $request
     */
    private function buildExecutionStack(MatchedRoute $route, Request $request) {

        $delegates = $this->addMiddlewareDelegates($route);
        $delegates = $this->addControllerDelegate($route, $delegates);

        return $this->stackDelegates($request, $delegates);
    }

    /**
     * @param MatchedRoute $route
     * @param $delegates
     * @return array
     */
    private function addControllerDelegate(MatchedRoute $route, $delegates): array {

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
    private function addMiddlewareDelegates(MatchedRoute $route): array {

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
     */
    private function stackDelegates(Request $request, $delegates) {

        $delegates = array_reverse($delegates);

        return array_reduce($delegates, function ($next, $delegate) use ($request) {

            if ($next == null) {
                return $delegate;
            }

            return $delegate($next ?: $request);
        });
    }
}