<?php namespace Monolith\Routing;

use Monolith\Collections\Collection;
use Monolith\Routing\Methods\RoutingMethod;

class WebRouteCompiler implements RouteCompiler {

    /** @var Collection */
    private $methods;

    public function addMethod(RoutingMethod $method): void {
        $this->methods = $this->methods->add($method);
    }

    public function compile(Collection $routes): CompiledRoutes {
        $compiled = new CompiledRoutes;
        foreach ($this->routes as $route) {
            $compiled = $compiled->add($this->findMethod($route)->compile($route));
        }
        return $compiled;
    }

    private function findMethod(Route $route): RouteMethod {
        /** @var RouteMethod $method */
        foreach ($this->methods as $method) {
            if ($method->handles($route->method())) {
                return $method;
            }
        }
        throw new \Exception("No method defined named {$route->method()}.");
    }
}