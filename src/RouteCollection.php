<?php namespace Monolith\Routing;

use Monolith\Collections\Collection;

class RouteCollection extends Collection {
    public function add(Route $value): Collection {
        return parent::add($value);
    }
}