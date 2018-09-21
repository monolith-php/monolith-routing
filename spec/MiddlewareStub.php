<?php namespace spec\Monolith\DependencyInjection;

use Monolith\Http\Request;
use Monolith\Http\Response;
use Monolith\WebRouting\Middleware;

final class MiddlewareStub implements Middleware {

    public function process(Request $request, $next): Response {
        d("middleware");
    }
}