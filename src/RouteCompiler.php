<?php namespace Monolith\Routing;

use Monolith\Collections\Collection;
use Monolith\Routing\Methods\RoutingMethod;

interface RouteCompiler {
    public function addMethod(RoutingMethod $method): void;
    public function compile(Collection $routes): CompiledRoutes;
}