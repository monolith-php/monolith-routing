<?php namespace Monolith\WebRouting;

use Monolith\Collections\Map;

class Route {

    /** @var string */
    private $method;
    /** @var string */
    private $uri;
    /** @var mixed */
    private $controllerClass;
    /** @var Map */
    private $params;

    public function __construct(string $method, string $uri, string $controllerClass, Map $params = null) {

        if ($params == null) {
            $params = new Map;
        }

        $this->method          = $method;
        $this->uri             = $uri;
        $this->controllerClass = $controllerClass;
        $this->params          = $params;
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

    public function params(): Map {
        return $this->params;
    }
}