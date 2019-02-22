<?php namespace Monolith\WebRouting;

use Monolith\Http\Request;

final class RouteMatcher
{
    public function match(Request $request, CompiledRoutes $routes): MatchedRoute
    {
        /** @var CompiledRoute $route */
        foreach ($routes as $route) {

            if ($this->routeMatches($request, $route)) {
                return new MatchedRoute($route);
            }
        }

        throw new CanNotMatchARouteForThisRequest($request->method() . ' :: ' . $request->uri());
    }

    /**
     * @param Request $request
     * @param $route
     * @return false|int
     */
    private function routeMatches(Request $request, CompiledRoute $route): bool
    {
        if ( ! $this->requestAndRouteMethodsMatch($request, $route)) {
            return false;
        }

        # remove query string from uri matching
        $matchablePartOfUri = stristr($request->rawDecodedUri(), '?') ? strstr($request->rawDecodedUri(), '?', true) : $request->rawDecodedUri();

        return (bool) preg_match($route->regex(), $matchablePartOfUri);
    }

    /**
     * @param Request $request
     * @param $route
     * @return bool
     */
    private function requestAndRouteMethodsMatch(Request $request, $route): bool
    {
        return $request->method() === $route->httpMethod();
    }
}