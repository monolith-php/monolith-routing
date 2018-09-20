<?php namespace Monolith\WebRouting\Controllers;

use Monolith\HTTP\{Request, Response};
use Monolith\WebRouting\RouteParameters;

interface PostController extends Controller {
    public function post(Request $request, RouteParameters $parameters): Response;
}