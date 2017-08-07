<?php namespace Monolith\WebRouting;

use Monolith\HTTP\Request;
use function rawurldecode;

class WebRouteMatcher implements RouteMatcher {
    public function match(Request $request, CompiledRoutes $routes): MatchedRoute {
        /** @var CompiledRoute $route */
        foreach ($routes as $route) {
            if (rawurldecode($request->uri()) === $route->regexPattern() && $request->method() === $route->httpMethod()) {
                return new MatchedRoute($route);
            }
        }
        throw new NoMatchingWebRouteForRequest($request);
    }
}