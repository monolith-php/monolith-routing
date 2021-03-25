<?php namespace spec\Monolith\WebRouting;

use Monolith\Http\Request;
use Monolith\Http\Response;

class ControllerRouteParameterStub
{
    public function index(): Response
    {
        return Response::ok('controller stub response');
    }

    public function parameterExample(Request $request): Response
    {
        return Response::ok($request->appParameters()->get('ab'));
    }
}