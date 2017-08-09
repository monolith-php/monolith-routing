<?php namespace Monolith\WebRouting;

use Monolith\Collections\Collection;

class RouteCompiler {

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
            $compiled = $compiled->add($this->compileThroughHandler($route));
        }
        return $compiled;
    }

    private function compileThroughHandler(Route $route): CompiledRoute {
        /** @var RouteHandler $handler */
        foreach ($this->handlers as $handler) {
            if ($handler->handles($route->identifier())) {
                return $handler->compile($route);
            }
        }
        throw new \Exception("No method defined named {$route->identifier()}.");
    }
}