<?php namespace Monolith\WebRouting;

class PostRoute implements Route {
    /** @var string */
    private $uri;
    /** @var mixed */
    private $controller;

    public function __construct(string $uri, $controller) {
        $this->uri = $uri;
        $this->controller = $controller;
    }

    public function identifier(): string {
        return 'post';
    }

    public function uri(): string {
        return $this->uri;
    }

    public function controller() {
        return $this->controller;
    }
}