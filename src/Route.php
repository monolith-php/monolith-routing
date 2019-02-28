<?php namespace Monolith\WebRouting;

final class Route implements RouteDefinition
{
    /** @var string */
    private $method;
    /** @var string */
    private $uri;
    /** @var mixed */
    private $controllerClass;
    /** @var RouteParameters */
    private $parameters;
    /** @var Middlewares */
    private $middlewares;

    public function __construct(string $method, string $uri, string $controllerClass, RouteParameters $parameters, Middlewares $middlewares)
    {
        $this->method = $method;

        $this->uri = static::prefixedUri($uri);

        $this->controllerClass = $controllerClass;
        $this->parameters = $parameters;
        $this->middlewares = $middlewares;
    }

    private static function prefixedUri(string $uri)
    {
        // make preceding frontslashs optional in routing declarations
        if (strlen($uri) > 0 && $uri[0] != '/') {
            return '/' . $uri;
        }
        return $uri;
    }

    public function method(): string
    {
        return $this->method;
    }

    public function uri(): string
    {
        return $this->uri;
    }

    public function controllerClass(): string
    {
        return $this->controllerClass;
    }

    public function parameters(): RouteParameters
    {
        return $this->parameters;
    }

    public function middlewares(): Middlewares
    {
        return $this->middlewares;
    }

    public function addMiddlewares(Middlewares $newMiddlewares): Route
    {
        return new static(
            $this->method,
            $this->uri,
            $this->controllerClass,
            $this->parameters,
            $this->middlewares->merge($newMiddlewares)
        );
    }
}