<?php namespace Monolith\WebRouting\RouteHandling;

use Monolith\HTTP\{Request, Response};

interface Get {
    public function get(Request $request): Response;
}