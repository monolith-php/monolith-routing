<?php namespace Monolith\WebRouting\Methods;

use Monolith\Http\{Request, Response};

interface FormController extends Controller {
    public function get(Request $request): Response;
    public function post(Request $request): Response;
}