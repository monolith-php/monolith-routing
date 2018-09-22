<?php namespace spec\Monolith\WebRouting;

use Monolith\Http\Request;
use Monolith\Http\Response;
use Monolith\WebRouting\Middleware;

final class OtherMiddlewareStub implements Middleware {

    public function process(Request $request, callable $next): Response {

        $response = $next($request);

        return Response::ok($response->body() . ' 2');
    }
}