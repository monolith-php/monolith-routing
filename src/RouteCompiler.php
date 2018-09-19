<?php namespace Monolith\WebRouting;

use Monolith\Collections\Collection;

class RouteCompiler {

    /** @var Collection */
    private $handlers;

    public function __construct() {
        $this->handlers = new Collection;
    }

    public function registerHandler(MethodCompiler $handler): void {
        $this->handlers = $this->handlers->add($handler);
    }

    public function compile(Collection $routes): CompiledRoutes {
        return new CompiledRoutes(
            $routes->map(function(Route $route) {
                return $this->compileRoutes($route);
            }, $routes));
    }

    private function compileRoutes(Route $route): CompiledRoute {
        /** @var MethodCompiler $handler */
        foreach ($this->handlers as $handler) {
            if ($handler->handles($route->method())) {
                return $handler->compile($route);
            }
        }
        throw new \Exception("No method defined named {$route->method()}.");
    }
}