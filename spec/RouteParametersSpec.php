<?php namespace spec\Monolith\WebRouting;

use Monolith\WebRouting\RequiredRouteParameterNotFound;
use Monolith\WebRouting\RouteParameters;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RouteParametersSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(RouteParameters::class);
    }

    function it_can_require_the_existence_of_parameters() {
        $this->beConstructedWith(['hats' => 'cats']);
        $this->require('hats')->shouldBe('cats');
        $this->shouldThrow(RequiredRouteParameterNotFound::class)->during('require', ['noexist']);
    }
}
