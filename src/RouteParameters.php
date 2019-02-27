<?php namespace Monolith\WebRouting;

use Monolith\Collections\Map;

final class RouteParameters extends Map
{
    public function require(string $key)
    {
        if ( ! $this->has($key)) {
            throw new RequiredRouteParameterNotFound($key);
        }

        return parent::get($key);
    }
}