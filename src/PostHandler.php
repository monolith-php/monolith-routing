<?php namespace Monolith\WebRouting;

use function strtolower;

class PostHandler implements RouteHandler {
    public function handles(string $identifier): bool {
        return strtolower($identifier) === 'post';
    }

    public function compile(Route $route): CompiledRoute {
        return CompiledRoute::POST($route->uri(), $route->controller(), 'post');
    }
}