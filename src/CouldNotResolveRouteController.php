<?php namespace Monolith\WebRouting;

class CouldNotResolveRouteController extends \Exception {
    public function __construct(string $className) {
        parent::__construct("Could not resolve route controller [{$className}].");
    }
}
