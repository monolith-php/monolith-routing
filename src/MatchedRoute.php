<?php namespace Monolith\WebRouting;

final class MatchedRoute {

    /** @var CompiledRoute */
    private $route;

    public function __construct(CompiledRoute $route) {
        $this->route = $route;
    }

    public function httpMethod(): string {
        return $this->route->httpMethod();
    }

    public function uri(): string {
        return $this->route->uri();
    }

    public function controllerClass(): string {
        return $this->route->controllerClass();
    }

    public function controllerMethod(): string {
        return $this->route->controllerMethod();
    }

    public function middlewares(): Middlewares {
        return $this->route->middlewares();
    }
}