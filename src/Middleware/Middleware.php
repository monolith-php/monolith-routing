<?php namespace Monolith\WebRouting\Middleware;

use Monolith\Http\{Request, Response};

interface Middleware {
    public function process(Request $request, $next): Response;
}