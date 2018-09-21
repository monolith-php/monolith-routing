<?php namespace spec\Monolith\DependencyInjection;

use Monolith\Http\Request;
use Monolith\Http\Response;
use Monolith\WebRouting\Middleware;

final class OtherMiddlewareStub implements Middleware {

    public function process(Request $request, callable $next): Response {
        
        return $next($request);
    }
}