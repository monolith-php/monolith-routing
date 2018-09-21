<?php namespace spec\Monolith\DependencyInjection;

use Monolith\Http\Request;
use Monolith\Http\Response;
use Monolith\WebRouting\Middleware;

final class MiddlewareStub implements Middleware {

    public function process(Request $request, callable $next): Response {

        /** @var Response $response */
        return $next($request);
    }
}