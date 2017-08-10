<?php namespace Monolith\WebRouting\Controllers;

use Monolith\HTTP\{Request, Response};
use Monolith\WebRouting\Parameters;

interface Get {
    public function get(Request $request, Parameters $parameters): Response;
}