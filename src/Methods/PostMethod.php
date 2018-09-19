<?php namespace Monolith\WebRouting\Methods;

use Monolith\WebRouting\MethodCompiler;
use Monolith\WebRouting\Route;
use Monolith\WebRouting\CompiledRoute;
use function strtolower;

class PostMethod implements MethodCompiler {

    public static function defineRoute(string $uri, string $controllerClass){
        return new Route('post', $uri, $controllerClass);
    }

    public function handles(string $method): bool {
        return strtolower($method) === 'post';
    }

    public function compile(Route $route): CompiledRoute {
        return new CompiledRoute('post', $route->uri(), $route->controllerClass(), 'post');
    }
}