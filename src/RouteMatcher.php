<?php namespace Monolith\Routing;

use Monolith\HTTP\Request;

class RouteMatcher {
    public function match(Request $request, CompiledRoutes $routes): MatchedRoute {
        /** @var CompiledRoute $route */
        foreach ($routes as $route) {
            if ($request->uri() === $route->pattern() && $request->method() === $route->httpMethod()) {
                return new MatchedRoute($route);
            }
        }
        throw new NoMatchingRouteForRequest($request);
    }
}