<?php namespace Monolith\Routing;

use Monolith\HTTP\{Request, Response};

interface ControllerDispatcher {
    public function dispatch(MatchedRoute $route, Request $request): Response;
}