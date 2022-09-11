<?php namespace Monolith\WebRouting;

use Exception;
use Traversable;
use IteratorAggregate;
use Monolith\Collections\Collection;
use JetBrains\PhpStorm\Internal\TentativeType;

final class CompiledRoutes implements IteratorAggregate
{
    private Collection $compiledRoutes;

    public function __construct(
        array $compiledRoutes = []
    ) {
        $this->compiledRoutes = Collection::of($compiledRoutes);
    }

    public function first(callable $f): ?CompiledRoute
    {
        return $this->compiledRoutes->first($f);
    }

    public static function list(
        ...$compiledRoutes
    ): self {
        return new self(
            $compiledRoutes
        );
    }

    public static function fromArray(
        array $compiledRoutes
    ): self {
        return new self(
            $compiledRoutes
        );
    }

    public function count(): int
    {
        return $this->compiledRoutes->count();
    }

    public function toArray(): array
    {
        return $this->compiledRoutes->toArray();
    }

    public function head(): ?CompiledRoute
    {
        return $this->compiledRoutes->head();
    }

    public function merge(self $that): self 
    {
        return new self(
            $this->compiledRoutes->merge($that->compiledRoutes)->toArray()
        );
    }

    public function getIterator(): Traversable
    {
        return $this->compiledRoutes->getIterator();
    }
}