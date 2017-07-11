<?php namespace Monolith\Routing\Methods;

use Monolith\Routing\CompiledRoute;
use Monolith\Routing\Route;

interface RoutingMethod {
    public function handles(string $method): bool;
    public function compile(Route $r): CompiledRoute;
}