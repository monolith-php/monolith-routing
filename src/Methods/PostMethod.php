<?php namespace Monolith\Routing\Methods;

use Monolith\Routing\CompiledRoute;
use Monolith\Routing\Route;

class PostMethod implements RoutingMethod {
    public function handles(string $method): bool {
        return $method === 'post';
    }

    public function compile(Route $r): CompiledRoute {
        return new CompiledRoute('POST', $r->uri(), $r->controller(), 'post', $r->options());
    }

    // might need this
    //    public function isControllerCompliant($controller) {
    //
    //    }
}