<?php namespace Monolith\WebRouting\Methods;

use Monolith\Http\{Request, Response};

interface GetController extends Controller {
    public function get(Request $request): Response;
}