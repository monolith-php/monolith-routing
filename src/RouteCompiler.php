<?php namespace Monolith\Routing;

use Monolith\Collections\Collection;

interface RouteCompiler {
    function addMethod(RoutingMethod $method): void;
    function compile(Collection $routes): CompiledRoutes;
}