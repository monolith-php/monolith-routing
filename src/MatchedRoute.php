<?php namespace Monolith\WebRouting;

class MatchedRoute {
    /** @var CompiledRoute */
    private $compiledRoute;

    public function __construct(CompiledRoute $compiledRoute) {
        $this->compiledRoute = $compiledRoute;
    }

    public function method(): string {
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
}