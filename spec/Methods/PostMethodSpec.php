<?php namespace spec\Monolith\WebRouting\Methods;

use Monolith\WebRouting\CompiledRoute;
use Monolith\WebRouting\CompiledRoutes;
use Monolith\WebRouting\Methods\PostMethod;
use Monolith\WebRouting\Route;
use PhpSpec\ObjectBehavior;

class PostMethodSpec extends ObjectBehavior {

    function it_is_initializable() {
        $this->shouldHaveType(PostMethod::class);
    }

    function it_can_define_a_post_route() {
        $route = $this::defineRoute('uri', 'controllerclass');
        $route->method()->shouldBe('post');
        $route->uri()->shouldBe('uri');
        $route->controllerClass()->shouldBe('controllerclass');
    }

    function it_can_compile_a_post_route() {
        $route = new Route('post', 'uri', 'controller');

        $compiled = $this->compile($route);
        $compiled->shouldHaveType(CompiledRoutes::class);

        $compiled->first()->shouldHaveType(CompiledRoute::class);
        $compiled->first()->httpMethod()->shouldBe('post');
        $compiled->first()->controllerName()->shouldBe('controller');
        $compiled->first()->controllerMethod()->shouldBe('post');
    }

}
