<?php namespace Monolith\WebRouting\Methods;

use Monolith\WebRouting\CompiledRoute;
use Monolith\WebRouting\CompiledRoutes;
use Monolith\WebRouting\MethodCompiler;
use Monolith\WebRouting\Middlewares;
use Monolith\WebRouting\Route;
use Monolith\WebRouting\RouteParameters;

final class PathMapMethod implements MethodCompiler
{
    public static function defineRoute(string $uri, string $rootPath, string $controllerClass): Route
    {
        return new Route(
            'path',
            $uri . '/{one?}/{two?}/{three?}/{four?}/{five?}/{six?}/{seven?}',
            $controllerClass,
            new RouteParameters([
                'rootPath' => $rootPath
            ]),
            Middlewares::list(PathRoutingMiddleware::class)
        );
    }

    public function handles(string $method): bool
    {
        return strtolower($method) === 'path';
    }

    public function compile(Route $route): CompiledRoutes
    {
        return new CompiledRoutes([
            new CompiledRoute('get', $route->uri(), $route->controllerClass(), 'get', $route->parameters(), $route->middlewares()),
        ]);
    }
}