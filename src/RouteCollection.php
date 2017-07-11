<?php namespace Monolith\Routing;

use Monolith\Collections\TypedCollection;

class RouteCollection extends TypedCollection {
    protected function collectionType(): string {
        return Route::class;
    }
}