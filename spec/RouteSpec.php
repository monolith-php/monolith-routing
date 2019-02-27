<?php namespace spec\Monolith\WebRouting;

use Monolith\WebRouting\Middlewares;
use Monolith\WebRouting\Route;
use Monolith\WebRouting\RouteParameters;
use PhpSpec\ObjectBehavior;

class RouteSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('method', 'uri', new RouteParameters(['controllerClass' => 'controllerclass']), new Middlewares);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Route::class);
        $this->method()->shouldBe('method');
        $this->uri()->shouldBe('/uri');
        $this->parameters()->get('controllerClass')->shouldBe('controllerclass');
        $this->middlewares()->equals(new Middlewares)->shouldBe(true);
    }

    function it_can_accept_uris_prefixed_with_frontslashes()
    {
        $this->beConstructedWith('method', '/uri', new RouteParameters(['controllerClass' => 'controllerclass']), new Middlewares);
        $this->uri()->shouldBe('/uri');
    }

    function it_doesnt_prefix_empty_uris()
    {
        $this->beConstructedWith('method', '', new RouteParameters(['controllerClass' => 'controllerclass']), new Middlewares);
        $this->uri()->shouldBe('');
    }
}
