<?php namespace Monolith\WebRouting\Methods;

use Monolith\WebRouting\CompiledRoute;
use Monolith\WebRouting\Route;
use Monolith\WebRouting\MethodCompiler;
use function strtolower;

class GetMethod implements MethodCompiler {

    public static function defineRoute(string $uri, string $controllerClass){
        return new Route('get', $uri, $controllerClass);
    }

    public function handles(string $method): bool {
        return strtolower($method) === 'get';
    }

    public function compile(Route $route): CompiledRoute {
        return new CompiledRoute('get', $route->uri(), $route->controllerClass(), 'get');
    }
}