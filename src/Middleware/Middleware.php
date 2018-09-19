<?php namespace Monolith\WebRouting\Middleware;

use Monolith\HTTP\Request;
use Monolith\HTTP\Response;

interface Middleware {
    public function process(Request $request, $next): Response;
}