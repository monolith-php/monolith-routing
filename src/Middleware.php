<?php namespace Monolith\WebRouting;

use Monolith\Http\{Request, Response};

interface Middleware
{
    public function process(
        Request $request,
        callable $next
    ): Response;
}