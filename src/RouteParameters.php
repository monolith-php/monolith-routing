<?php namespace Monolith\WebRouting;

use Monolith\Collections\Dictionary;

final class RouteParameters
{
    private Dictionary $parameters;
    
    public function __construct(
        array $parameters = []
    ) {
        $this->parameters = Dictionary::of($parameters);
    }

    public function get($key)
    {
        return $this->parameters->get($key);
    }
    
    public function toArray(): array
    {
        return $this->parameters->toArray();
    }
}