<?php namespace Monolith\WebRouting;

use Monolith\HTTP\Request;

interface RouteMatcher {
    public function match(Request $request, CompiledRoutes $routes): MatchedRoute;
}