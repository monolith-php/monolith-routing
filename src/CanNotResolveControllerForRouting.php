<?php namespace Monolith\WebRouting;

class CanNotResolveControllerForRouting extends WebRoutingException {
    public function __construct(string $className) {
        parent::__construct("Could not resolve route controller [{$className}].");
    }
}
