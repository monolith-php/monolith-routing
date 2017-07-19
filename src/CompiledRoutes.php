<?php namespace Monolith\Routing;

use Monolith\Collections\Collection;

class CompiledRoutes extends Collection {
    public function add(CompiledRoute $value): Collection {
        return parent::add($value);
    }
}