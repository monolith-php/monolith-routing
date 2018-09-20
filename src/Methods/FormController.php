<?php namespace Monolith\WebRouting\Methods;

use Monolith\HTTP\{Request, Response};
use Monolith\WebRouting\RouteParameters;

interface FormController extends Controller {
    public function get(Request $request, RouteParameters $parameters): Response;
    public function post(Request $request, RouteParameters $parameters): Response;
}