<?php namespace spec\Monolith\WebRouting\Methods;

use Monolith\WebRouting\CompiledRoute;
use Monolith\WebRouting\CompiledRoutes;
use Monolith\WebRouting\MethodCompiler;
use Monolith\WebRouting\Middlewares;
use Monolith\WebRouting\Route;

final class StubMethod implements MethodCompiler {

    public function handles(string $method): bool {
        return strtolower($method) == 'stub';
    }

    public function compile(Route $route): CompiledRoutes {
        return CompiledRoutes::list(
            new CompiledRoute('get', $route->uri(), $route->controllerClass(), 'index', new Middlewares)
        );
    }
}