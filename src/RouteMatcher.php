<?php namespace Monolith\WebRouting;

use Monolith\Http\Request;

class RouteMatcher {

    public function match(Request $request, CompiledRoutes $routes): MatchedRoute {

        /** @var CompiledRoute $route */
        foreach ($routes as $route) {

            if ($this->routeMatches($request, $route)) {
                return new MatchedRoute($route);
            }
        }

        throw new CanNotMatchARouteForThisRequest($request);
    }

    /**
     * @param Request $request
     * @param $route
     * @return false|int
     */
    private function routeMatches(Request $request, CompiledRoute $route) {

        if ( ! $this->requestAndRouteMethodsMatch($request, $route)) {
            return false;
        }

        return preg_match($route->regex(), $request->rawDecodedUri());
    }

    /**
     * @param Request $request
     * @param $route
     * @return bool
     */
    private function requestAndRouteMethodsMatch(Request $request, $route): bool {

        return $request->method() === $route->httpMethod();
    }
}