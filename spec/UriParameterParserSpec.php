<?php namespace spec\Monolith\WebRouting;

use Monolith\WebRouting\CompiledRoute;
use Monolith\WebRouting\Middlewares;
use Monolith\WebRouting\RouteParameters;
use Monolith\WebRouting\UriParameterParser;
use PhpSpec\ObjectBehavior;

class UriParameterParserSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(UriParameterParser::class);
    }

    function it_can_parse_uri_parameters()
    {
        $compiledRoute = new CompiledRoute('httpmethod', '/action/{id}', 'controllerclass', 'controllermethod', new RouteParameters, new Middlewares);
        $parameters = UriParameterParser::parseUriParameters('/action/213-321-abc', $compiledRoute->regex());
        expect($parameters['id'])->shouldBe('213-321-abc');
    }
}
