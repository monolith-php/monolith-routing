<?php namespace Monolith\WebRouting;

interface MethodCompiler {
    public function handles(string $method): bool;
    public function compile(Route $route): CompiledRoute;
}