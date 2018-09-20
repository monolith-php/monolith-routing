<?php namespace Monolith\WebRouting;

use Monolith\Http\Request;

final class CanNotMatchARouteForThisRequest extends WebRoutingException {

    public function __construct(Request $request) {

        parent::__construct("No matching route for request uri: \"{$request->uri()}\".");
    }
}