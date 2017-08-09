<?php namespace Monolith\WebRouting;

interface RouteHandler {
    public function handles(string $identifier): bool;
    public function compile(Route $route): CompiledRoute;
}