<?php namespace spec\Monolith\WebRouting\Methods;

use Monolith\Collections\Dict;
use Monolith\Http\Request;
use Monolith\Http\Response;
use Monolith\WebRouting\Methods\PathRoutingMiddleware;
use PhpSpec\ObjectBehavior;

class PathRoutingMiddlewareSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(PathRoutingMiddleware::class);
    }

    function it_can_build_a_path_out_of_a_route()
    {
        $request = Request::fromGlobals();
        $request = $request->addParameters(new Dict([
            'one'   => '3',
            'two'   => '4',
            'three' => '5',
            'four'  => '6',
            'five'  => '7',
            'six'   => '8',
            'seven' => '9',
        ]));

        $this->process($request, function (Request $request) {
            expect($request->parameters()->get('path'))->shouldBe('/3/4/5/6/7/8/9');
            return Response::ok('');
        });
    }
}
