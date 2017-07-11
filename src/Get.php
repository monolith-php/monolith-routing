<?php namespace Monolith\Routing;

use Monolith\HTTP\Request;
use Monolith\HTTP\Response;

interface Get extends Controller {
    public function get(Request $r): Response;
}