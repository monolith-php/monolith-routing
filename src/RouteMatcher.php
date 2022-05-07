<?php namespace Monolith\WebRouting;

use Monolith\Http\Request;

final class RouteMatcher
{
    public function match(
        Request $request,
        CompiledRoutes $routes
    ): MatchedRoute {
        /** @var CompiledRoute $route */
        foreach ($routes as $route) {

            if ($this->routeMatches($request, $route)) {
                return new MatchedRoute($route);
            }
        }

        throw CanNotMatchRoute::forRequest($request);
    }

    private function routeMatches(
        Request $request,
        CompiledRoute $route
    ): bool {
        if ( ! $this->requestAndRouteMethodsMatch($request, $route)) {
            return false;
        }

        return (bool) preg_match($route->regex(), $request->uri());
    }

    private function requestAndRouteMethodsMatch(
        Request $request,
        $route
    ): bool {
        return $request->method() === $route->httpMethod();
    }
}