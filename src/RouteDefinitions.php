<?php namespace Monolith\WebRouting;

use Monolith\Collections\Collection;

final class RouteDefinitions implements RouteDefinition
{
    private Collection $items;
    private $transformFunction;

    public function __construct(
        array $items = [],
        callable $transformFunction = null
    ) {
        $this->items = Collection::of($items);
        $this->transformFunction = $transformFunction;
    }

    public function add(RouteDefinition $definition): self 
    {
        return new self(
            $this->items->add($definition)->toArray(),
            $this->transformFunction
        );
    }

    public function toArray(): array
    {
        return $this->items->toArray();
    }

    public static function withTransformFunction(
        callable $transformFunction,
        ...$items
    ): RouteDefinitions {
        return new self(
            $items,
            $transformFunction
        );
    }

    public function merge(
        self $that
    ): self {
        return new self(
            $this->items->merge($that->items)->toArray(),
            $this->transformFunction
        );
    }

    public function reverse(): self
    {
        return new self(
            $this->items->reverse()->toArray(),
            $this->transformFunction
        );
    }

    public function map(?callable $f): self 
    {
        return new self(
            $this->items->map($f)->toArray(),
            $this->transformFunction
        );
    }

    public function reduce(?callable $f, $initial): mixed 
    {
        return $this->items->reduce($f, $initial);
    }
    
    public function flatten(
        callable $parentTransformFunction = null
    ): self {
        // flatten all route definitions
        $flatten = function ($route) {
            if ($route instanceof RouteDefinitions) {
                return $route->flatten();
            }
            
            return $route;
        };

        // reduce all route definitions to a single list
        $reduceToSingleList = function (RouteDefinitions $accumulation, $definition) {
            if ($definition instanceof RouteDefinitions) {
                return new RouteDefinitions($accumulation->merge($definition)->toArray());
            }

            return $accumulation->add($definition);
        };

        // map / reduce children into a single flat list of routes
        $flattenedRoutes = $this
            ->reverse()
            ->map($flatten)
            ->reduce($reduceToSingleList, new RouteDefinitions);
        
        // apply transformations
        return array_reduce(
            array_filter([$parentTransformFunction, $this->transformFunction]),
            fn($routes, $transform) => $routes->map($transform),
            $flattenedRoutes
        );
    }

    public static function list(Route|RouteDefinitions ...$routes): self
    {
        return new self($routes);
    }

    public function count(): int
    {
        return $this->items->count();
    }

    public function each(callable $f): void 
    {
        $this->items->each($f);
    }
}