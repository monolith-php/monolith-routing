<?php namespace spec\Monolith\WebRouting;

use Monolith\WebRouting\Middlewares;
use Monolith\WebRouting\Route;
use Monolith\WebRouting\RouteCompiler;
use Monolith\WebRouting\RouteDefinitions;
use PhpSpec\ObjectBehavior;
use spec\Monolith\WebRouting\Methods\StubMethod;

class RouteCompilerSpec extends ObjectBehavior {

    function it_is_initializable() {

        $this->shouldHaveType(RouteCompiler::class);
    }

    function it_can_register_method_compiler_strategies() {
        $this->registerMethodCompiler(new StubMethod);
    }

    function it_can_compile_a_route_using_the_registered_compilers() {
        $route = new Route('stub', 'uri', 'controllerclass', new Middlewares);

        $this->registerMethodCompiler(new StubMethod);

        $compiledRoutes = $this->compile(RouteDefinitions::list(
            $route
        ));

        $compiledRoutes->head()->httpMethod()->shouldBe('get');
        $compiledRoutes->head()->uri()->shouldBe('uri');
        $compiledRoutes->head()->controllerClass()->shouldBe('controllerclass');
        $compiledRoutes->head()->controllerMethod()->shouldBe('index');
    }
}
