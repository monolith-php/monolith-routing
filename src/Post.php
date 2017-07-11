<?php namespace Monolith\Routing;

use Monolith\HTTP\Request;
use Monolith\HTTP\Response;

interface Post extends Controller {
    public function post(Request $r): Response;
}