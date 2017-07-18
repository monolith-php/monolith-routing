<?php namespace Monolith\Routing\Methods;

use Monolith\HTTP\Request;
use Monolith\HTTP\Response;
use Monolith\Routing\Controller;

interface Post extends Controller {
    public function post(Request $r): Response;
}