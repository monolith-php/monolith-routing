<?php namespace Monolith\WebRouting;

use Monolith\HTTP\Request;
use function array_filter;
use function is_string;
use const ARRAY_FILTER_USE_KEY;

class RouteMatcher {

    public function match(Request $request, CompiledRoutes $routes): MatchedRoute {
        /** @var CompiledRoute $route */
        foreach ($routes as $route) {
            // HEAD is equivalent to GET
            $requestMethod = $request->method() === 'HEAD' ? 'get' : $request->method();
            $matches       = [];
            if ($requestMethod === $route->httpMethod() && preg_match($route->regex(), $request->rawDecodedUri(), $matches)) {
                $parameters = array_filter($matches, function ($key) {
                    return is_string($key);
                }, ARRAY_FILTER_USE_KEY);
                return new MatchedRoute($route, new RouteParameters($parameters));
            }
        }
        throw new NoMatchingWebRouteForRequest($request);
    }
}