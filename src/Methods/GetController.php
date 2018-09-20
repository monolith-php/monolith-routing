<?php namespace Monolith\WebRouting\Methods;

use Monolith\HTTP\{Request, Response};
use Monolith\WebRouting\RouteParameters;

interface GetController extends Controller {
    public function get(Request $request, RouteParameters $parameters): Response;
}