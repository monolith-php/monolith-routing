<?php namespace Monolith\WebRouting\RouteHandling;

use Monolith\WebRouting\Route;

class GetRoute implements Route {
    /** @var string */
    private $uri;
    /** @var mixed */
    private $controller;

    public function __construct(string $uri, $controller) {
        $this->uri = $uri;
        $this->controller = $controller;
    }

    public function identifier(): string {
        return 'get';
    }

    public function uri(): string {
        return $this->uri;
    }

    public function controller() {
        return $this->controller;
    }
}