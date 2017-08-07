<?php namespace Monolith\WebRouting;

use Monolith\Collections\Collection;
use Monolith\WebRouting\RouteHandling\RouteHandler;

interface RouteCompiler {
    public function registerHandler(RouteHandler $handler): void;
    public function compile(Collection $routes): CompiledRoutes;
}