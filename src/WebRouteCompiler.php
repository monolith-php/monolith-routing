<?php namespace Monolith\WebRouting;

use Monolith\Collections\Collection;
use Monolith\WebRouting\RouteHandling\RouteHandler;

class WebRouteCompiler implements RouteCompiler {

    /** @var Collection */
    private $handlers;

    public function __construct() {
        $this->handlers = new Collection;
    }

    public function registerHandler(RouteHandler $handler): void {
        $this->handlers = $this->handlers->add($handler);
    }

    public function compile(Collection $routes): CompiledRoutes {
        $compiled = new CompiledRoutes;
        foreach ($routes as $route) {
            $compiled = $compiled->add($this->findMethod($route)->compile($route));
        }
        return $compiled;
    }

    private function findMethod(Route $route): RouteMethod {
        /** @var RouteMethod $method */
        foreach ($this->handlers as $method) {
            if ($method->handles($route->name())) {
                return $method;
            }
        }
        throw new \Exception("No method defined named {$route->name()}.");
    }
}