<?php namespace Monolith\WebRouting;

final class Route implements RouteDefinition
{
    /** @var string */
    private $method;
    /** @var string */
    private $uri;
    /** @var Middlewares */
    private $middlewares;
    /** @var RouteParameters */
    private $parameters;

    public function __construct(string $method, string $uri, RouteParameters $parameters, Middlewares $middlewares)
    {
        $this->method = $method;

        $this->uri = static::prefixedUri($uri);

        $this->middlewares = $middlewares;
        $this->parameters = $parameters;
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
            $this->parameters,
            $this->middlewares->merge($newMiddlewares)
        );
    }
}