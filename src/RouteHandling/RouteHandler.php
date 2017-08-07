<?php namespace Monolith\WebRouting\RouteHandling;

use Monolith\WebRouting\CompiledRoute;
use Monolith\WebRouting\Route;

interface RouteHandler {
    public function handles(string $method): bool;
    public function compile(Route $route): CompiledRoute;
}