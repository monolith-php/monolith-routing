<?php namespace Monolith\WebRouting;

use Monolith\HTTP\Request;

final class NoMatchingWebRouteForRequest extends WebRoutingException {
    public function __construct(Request $request) {
        parent::__construct("No matching route for request uri: \"{$request->uri()}\".");
    }
}