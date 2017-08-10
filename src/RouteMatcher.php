<?php namespace Monolith\WebRouting;

use function array_filter;
use const ARRAY_FILTER_USE_KEY;
use function is_string;
use Monolith\HTTP\Request;

class RouteMatcher {
    public function match(Request $request, CompiledRoutes $routes): MatchedRoute {
        /** @var CompiledRoute $route */
        foreach ($routes as $route) {
            // HEAD is equivalent to GET
            $requestMethod = $request->method() === 'HEAD' ? 'GET' : $request->method();
            $matches = [];
            if ($requestMethod === $route->httpMethod() && preg_match($route->regex(), $request->rawDecodedUri(), $matches)) {
                $parameters = array_filter($matches, function($key) {
                    return is_string($key);
                }, ARRAY_FILTER_USE_KEY);
                dd(new Parameters($parameters));
                return new MatchedRoute($route);
            }
        }
        throw new NoMatchingWebRouteForRequest($request);
    }
}