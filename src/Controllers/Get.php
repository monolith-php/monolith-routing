<?php namespace Monolith\WebRouting\Controllers;

use Monolith\HTTP\{Request, Response};
use Monolith\WebRouting\RouteParameters;

interface Get {
    public function get(Request $request, RouteParameters $parameters): Response;
}