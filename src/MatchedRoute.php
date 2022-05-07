<?php namespace Monolith\WebRouting;

final class MatchedRoute
{
    private CompiledRoute $compiledRoute;

    public function __construct(
        CompiledRoute $compiledRoute
    ) {
        $this->compiledRoute = $compiledRoute;
    }

    public function httpMethod(): string
    {
        return $this->compiledRoute->httpMethod();
    }

    public function uri(): string
    {
        return $this->compiledRoute->uri();
    }

    public function regex(): string
    {
        return $this->compiledRoute->regex();
    }

    public function controllerClass(): string
    {
        return $this->compiledRoute->controllerClass();
    }

    public function controllerMethod(): string
    {
        return $this->compiledRoute->controllerMethod();
    }

    public function parameters(): RouteParameters
    {
        return $this->compiledRoute->parameters();
    }

    public function middlewares(): Middlewares
    {
        return $this->compiledRoute->middlewares();
    }
}