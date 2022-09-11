<?php namespace Monolith\WebRouting;

use Countable;
use Monolith\Collections\Collection;

final class Middlewares implements Countable
{
    private Collection $middlewares;

    public function __construct(
        array $middlewares = []
    ) {
        $this->middlewares = Collection::of($middlewares);
    }

    public function merge(Middlewares $that): self
    {
        return new self(
            $this->middlewares->merge($that->middlewares)->toArray()
        );
    }

    public function map(callable $f): Collection
    {
        return $this->middlewares->map($f);
    }

    public function equals(self $that): bool 
    {
        return $this->middlewares->equals($that->middlewares);
    }

    public static function list(...$middlewares): self
    {
        return new self($middlewares);
    }

    public function count(): int
    {
        return $this->middlewares->count();
    }
}