<?php namespace Monolith\Routing;

class CompiledRoute {
    /** @var string */
    private $httpMethod;
    /** @var string */
    private $pattern;
    /** @var string */
    private $controllerClass;
    /** @var string */
    private $controllerMethod;
    /** @var RouteOptions */
    private $options;

    public function __construct(string $httpMethod, string $pattern, string $controllerClass, string $controllerMethod, RouteOptions $options = null) {
        $this->httpMethod = strtoupper($httpMethod);
        $this->pattern = $pattern;
        $this->controllerClass = $controllerClass;
        $this->controllerMethod = $controllerMethod;
        $this->options = $options;
    }

    public function httpMethod(): string {
        return $this->httpMethod;
    }

    public function pattern(): string {
        return $this->pattern;
    }

    public function controllerClass(): string {
        return $this->controllerClass;
    }

    public function controllerMethod(): string {
        return $this->controllerMethod;
    }

    public function options(): RouteOptions {
        return $this->options;
    }
}