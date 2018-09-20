<?php namespace spec\Monolith\WebRouting;

use Monolith\WebRouting\Route;
use PhpSpec\ObjectBehavior;

class RouteSpec extends ObjectBehavior {

    function let() {
        $this->beConstructedWith('method', 'uri', 'controllerclass');
    }

    function it_is_initializable() {

        $this->shouldHaveType(Route::class);
        $this->method()->shouldBe('method');
        $this->uri()->shouldBe('uri');
        $this->controllerClass()->shouldBe('controllerclass');
    }
}
