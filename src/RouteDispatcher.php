<?php namespace Monolith\Routing;

use Monolith\HTTP\{Request, Response};

interface RouteDispatcher {
    public function dispatch(MatchedRoute $route, Request $request): Response;
}