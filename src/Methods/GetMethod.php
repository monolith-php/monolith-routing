<?php namespace Monolith\Routing\Methods;

use Monolith\Routing\CompiledRoute;
use Monolith\Routing\Route;

class GetMethod implements RoutingMethod {
    public function handles(string $method): bool {
        return $method === 'get';
    }

    public function compile(Route $r): CompiledRoute {
        return new CompiledRoute('GET', $r->uri(), $r->controller(), 'get', $r->options());
    }
}