<?php namespace Monolith\WebRouting\RouteHandling;

use Monolith\WebRouting\Route;

class GetRoute extends Route {
    public function __construct(string $uri, $controller) {
        parent::__construct('get', $uri, $controller);
    }
}