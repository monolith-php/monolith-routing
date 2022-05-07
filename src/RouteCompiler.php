<?php namespace Monolith\WebRouting;

use Monolith\Collections\Collection;

final class RouteCompiler
{
    private Collection $methodCompilers;

    public function __construct()
    {
        $this->methodCompilers = new Collection;
    }

    public function registerMethodCompiler(
        MethodCompiler $methodCompiler
    ): void {
        $this->methodCompilers = $this->methodCompilers->add($methodCompiler);
    }

    // give me a flat list of routes baby
    public function compile(
        RouteDefinitions $routes
    ): CompiledRoutes {
        $compiledRoutes = $routes
            ->flatten()
            ->map(
                fn(Route $route) => $this->compileRoute($route)
            );

        return $compiledRoutes
            ->reduce(
                fn(CompiledRoutes $routes, CompiledRoutes $allRoutes) => $allRoutes->merge($routes), new CompiledRoutes
            );
    }

    private function compileRoute(
        Route $route
    ): CompiledRoutes {
        /** @var MethodCompiler $handler */
        foreach ($this->methodCompilers as $handler) {
            if ($handler->handles($route->method())) {
                return $handler->compile($route);
            }
        }

        throw CanNotCompileRoute::noCompilerForMethod($route->method());
    }
}