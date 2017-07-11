<?php namespace Monolith\Routing;

use Monolith\HTTP\Request;

final class NoMatchingRouteForRequest extends \Exception {
    public function __construct(Request $request) {
        parent::__construct("No matching route for request uri: \"{$request->uri()}\".");
    }
}