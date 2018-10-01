<?php namespace spec\Monolith\WebRouting;

use Monolith\Http\Response;

class ControllerStub
{
    public function index(): Response
    {
        return Response::ok('controller stub response');
    }
}