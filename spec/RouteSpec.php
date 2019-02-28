<?php namespace spec\Monolith\WebRouting;

use Monolith\WebRouting\Middlewares;
use Monolith\WebRouting\Route;
use Monolith\WebRouting\RouteParameters;
use PhpSpec\ObjectBehavior;

class RouteSpec extends ObjectBehavior
{
    private $parameters;

    function let()
    {
        $this->parameters = new RouteParameters(['ab' => 'cd']);
        $this->beConstructedWith('method', 'uri', 'controllerclass', $this->parameters, new Middlewares);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Route::class);
        $this->method()->shouldBe('method');
        $this->uri()->shouldBe('/uri');
        $this->controllerClass()->shouldBe('controllerclass');
        $this->parameters()->toArray()->shouldBe($this->parameters->toArray());
        $this->middlewares()->equals(new Middlewares)->shouldBe(true);
    }

    function it_can_accept_uris_prefixed_with_frontslashes()
    {
        $this->beConstructedWith('method', '/uri', 'controllerclass', new RouteParameters(), new Middlewares);
        $this->uri()->shouldBe('/uri');
    }

    function it_doesnt_prefix_empty_uris()
    {
        $this->beConstructedWith('method', '', 'controllerclass', new RouteParameters(), new Middlewares);
        $this->uri()->shouldBe('');
    }
}
