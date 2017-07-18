<?php namespace Monolith\Routing;

class MatchedRoute {
    /** @var CompiledRoute */
    private $compiledRoute;

    public function __construct(CompiledRoute $compiledRoute) {
        $this->compiledRoute = $compiledRoute;
    }

    public function httpMethod(): string {
        return $this->compiledRoute->httpMethod();
    }

    public function pattern(): string {
        return $this->compiledRoute->pattern();
    }

    public function controllerClass(): string {
        return $this->compiledRoute->controllerClass();
    }

    public function controllerMethod(): string {
        return $this->compiledRoute->controllerMethod();
    }

    public function options(): RouteOptions {
        return $this->compiledRoute->options();
    }
}