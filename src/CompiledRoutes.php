<?php namespace Monolith\Routing;

use Monolith\Collections\TypedCollection;

class CompiledRoutes extends TypedCollection {
    protected function collectionType(): string {
        return CompiledRoute::class;
    }
}