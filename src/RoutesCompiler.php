<?php namespace Monolith\WebRouting;

use Monolith\Collections\Collection;
use Monolith\WebRouting\RouteHandling\RouteHandler;

class RoutesCompiler {
    public function compile(Collection $handlers, Collection $routes): CompiledRoutes {
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