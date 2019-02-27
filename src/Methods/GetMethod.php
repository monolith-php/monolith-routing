<?php namespace Monolith\WebRouting\Methods;

use Monolith\WebRouting\CompiledRoute;
use Monolith\WebRouting\CompiledRoutes;
use Monolith\WebRouting\MethodCompiler;
use Monolith\WebRouting\Middlewares;
use Monolith\WebRouting\Route;
use Monolith\WebRouting\RouteParameters;
use function strtolower;

final class GetMethod implements MethodCompiler
{
    public static function defineRoute(string $uri, string $controllerClass): Route
    {
        return new Route('get', $uri, new RouteParameters([
            'controllerClass' => $controllerClass,
        ]), new Middlewares);
    }

    public function handles(string $method): bool
    {
        return strtolower($method) === 'get';
    }

    public function compile(Route $route): CompiledRoutes
    {
        return new CompiledRoutes([
            new CompiledRoute('get', $route->uri(), $route->parameters()->require('controllerClass'), 'get', $route->middlewares()),
        ]);
    }
}