<?php namespace Monolith\WebRouting\Controllers;

use Monolith\HTTP\{Request, Response};

interface Get {
    public function get(Request $request): Response;
}