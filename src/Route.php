<?php namespace Monolith\WebRouting;

final class Route {

    /** @var string */
    private $method;
    /** @var string */
    private $uri;
    /** @var mixed */
    private $controllerClass;
    /** @var Middlewares */
    private $middlewares;

    public function __construct(string $method, string $uri, string $controllerClass, Middlewares $middlewares = null) {

        if ($middlewares == null) {
            $middlewares = new Middlewares;
        }

        $this->method = $method;
        $this->uri = $uri;
        $this->controllerClass = $controllerClass;
        $this->middlewares = $middlewares;
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

    public function middlewares(): Middlewares {
        return $this->middlewares;
    }

    public function addMiddlewares(Middlewares $newMiddlewares): Route {
        return new static(
            $this->method,
            $this->uri,
            $this->controllerClass,
            $this->middlewares->merge($newMiddlewares)
        );
    }
}