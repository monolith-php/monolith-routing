<?php namespace spec\Monolith\WebRouting\Methods;

use Monolith\WebRouting\CompiledRoute;
use Monolith\WebRouting\CompiledRoutes;
use Monolith\WebRouting\Methods\GetMethod;
use Monolith\WebRouting\Route;
use PhpSpec\ObjectBehavior;

class GetMethodSpec extends ObjectBehavior {

    function it_is_initializable() {
        $this->shouldHaveType(GetMethod::class);
    }

    function it_can_define_a_get_route() {
        $route = $this::defineRoute('uri', 'controllerclass');
        $route->method()->shouldBe('get');
        $route->uri()->shouldBe('uri');
        $route->controllerClass()->shouldBe('controllerclass');
    }

    function it_can_compile_a_get_route() {
        $route = new Route('get', 'uri', 'controller');

        $compiled = $this->compile($route);
        $compiled->shouldHaveType(CompiledRoutes::class);

        $compiled->head()->shouldHaveType(CompiledRoute::class);
        $compiled->head()->httpMethod()->shouldBe('get');
        $compiled->head()->controllerName()->shouldBe('controller');
        $compiled->head()->controllerMethod()->shouldBe('get');
    }
}
