<?php namespace Monolith\WebRouting\Methods;

use Monolith\Http\{Request, Response};

interface PostController extends Controller
{
    public function post(
        Request $request
    ): Response;
}