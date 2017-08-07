<?php namespace Monolith\WebRouting;

abstract class Route {
    private $name;
    private $uri;
    private $controller;

    public function __construct(string $name, string $uri, $controller) {
        $this->name       = $name;
        $this->uri        = $uri;
        $this->controller = $controller;
    }

    public function name(): string {
        return $this->name;
    }

    public function uri(): string {
        return $this->uri;
    }

    public function controller() {
        return $this->controller;
    }
}