<?php namespace spec\Monolith\WebRouting;

use Monolith\WebRouting\CompiledRoute;
use PhpSpec\ObjectBehavior;
use spec\Monolith\DependencyInjection\ControllerStub;

class CompiledRouteSpec extends ObjectBehavior {

    function let() {
        $this->beConstructedWith('get', 'uri', ControllerStub::class, 'index');
    }

    function it_is_initializable() {
        $this->shouldHaveType(CompiledRoute::class);
    }
}