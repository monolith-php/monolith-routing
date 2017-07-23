<?php namespace Monolith\Routing;

use Monolith\Routing\Methods\MethodIdentifier;

final class Route {

    private $method;
    private $uri;
    private $controller;

    public function __construct($method, string $uri, $controller) {
        $this->method = $method;
        $this->uri = $uri;
        $this->controller = $controller;
    }

    public function method(): string {
        return $this->method;
    }

    public function uri(): string {
        return $this->uri;
    }

    public function controller() {
        return $this->controller;
    }
}