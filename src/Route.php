<?php namespace Monolith\WebRouting;

class Route {

    /** @var string */
    private $method;
    /** @var string */
    private $uri;
    /** @var mixed */
    private $controllerClass;

    public function __construct(string $method, string $uri, string $controllerClass) {

        $this->method          = $method;
        $this->uri             = $uri;
        $this->controllerClass = $controllerClass;
    }

    public function method(): string {
        return $this->method;
    }

    public function uri(): string {
        return $this->uri;
    }

    public function controllerClass(): string {
        return $this->controllerClass;
    }
}