<?php namespace Monolith\Routing\Methods;

use Monolith\HTTP\Request;
use Monolith\HTTP\Response;
use Monolith\Routing\Controller;

interface Get extends Controller {
    public function get(Request $r): Response;
}