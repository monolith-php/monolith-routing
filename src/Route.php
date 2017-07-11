<?php namespace Monolith\Routing;

use Monolith\Routing\Methods\MethodIdentifier;

final class Route {

    private $method;
    private $uri;
    private $controller;
    private $options;

    public function __construct($method, string $uri, $controller, ?RouteOptions $options = null) {
        $this->method = $method;
        $this->uri = $uri;
        $this->controller = $controller;
        $this->options = $options ?: new RouteOptions;
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

    public function options(): RouteOptions {
        return $this->options;
    }

    // not sure
    public function withOptions(RouteOptions $options): Route {
        return new Route($this->method, $this->uri, $this->handler, $options);
    }
}