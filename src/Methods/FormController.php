<?php namespace Monolith\WebRouting\Methods;

use Monolith\Http\{Request, Response};

interface FormController extends Controller {

    public function form(Request $request): Response;

    public function submit(Request $request): Response;
}