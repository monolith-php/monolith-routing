<?php namespace Monolith\WebRouting;

use Monolith\HTTP\Request;

class RouteMatcher {
    public function match(Request $request, CompiledRoutes $routes): MatchedRoute {
        /** @var CompiledRoute $route */
        foreach ($routes as $route) {
            // HEAD is equivalent to GET
            $requestMethod = $request->method() === 'HEAD' ? 'GET' : $request->method();
            $matches = [];
            if ($requestMethod === $route->httpMethod() && preg_match($route->regex(), $request->rawDecodedUri(), $matches)) {
                dd($matches);
                return new MatchedRoute($route);
            }
        }
        throw new NoMatchingWebRouteForRequest($request);
    }
}