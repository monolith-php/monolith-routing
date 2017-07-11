<?php namespace Monolith\Routing;

interface ControllerResolver {
    public function resolve(string $controller);
}