<?php namespace Monolith\WebRouting;

final class MatchedRoute {
    /** @var CompiledRoute */
    private $route;
    /** @var RouteParameters */
    private $parameters;

    public function __construct(CompiledRoute $route, RouteParameters $parameters) {
        $this->route      = $route;
        $this->parameters = $parameters;
    }

    public function httpMethod(): string {
        return $this->route->httpMethod();
    }

    public function controllerName(): string {
        return $this->route->controllerName();
    }

    public function controllerMethod(): string {
        return $this->route->controllerMethod();
    }

    public function parameters(): RouteParameters {
        return $this->parameters;
    }
}