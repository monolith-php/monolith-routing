<?php namespace Monolith\WebRouting;

use Monolith\Collections\Collection;

final class RouteCompiler {

    /** @var Collection */
    private $methodCompilers;

    public function __construct() {

        $this->methodCompilers = new Collection;
    }

    public function registerMethodCompiler(MethodCompiler $methodCompiler): void {

        $this->methodCompilers = $this->methodCompilers->add($methodCompiler);
    }

    // give me a flat list of routes baby
    public function compile(RouteDefinitions $routes): CompiledRoutes {

        $compiledRoutes = $routes->map(function (Route $route) {

            return $this->compileRoute($route);
        });

        return $compiledRoutes->reduce(function (CompiledRoutes $routes, CompiledRoutes $allRoutes) {

            return $allRoutes->merge($routes);
        }, new CompiledRoutes);
    }

    private function compileRoute(Route $route): CompiledRoutes {

        /** @var MethodCompiler $handler */
        foreach ($this->methodCompilers as $handler) {
            if ($handler->handles($route->method())) {
                return $handler->compile($route);
            }
        }

        throw new CanNotCompileARouteWithMethod($route->method());
    }
}