<?php namespace Monolith\WebRouting;

use Monolith\HTTP\{Request, Response};

interface RouteDispatcher {

    public function dispatch(MatchedRoute $route, Request $request): Response;
}