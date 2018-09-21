<?php namespace spec\Monolith\WebRouting;

use Monolith\Http\Response;

class ControllerStub {

    public function index(): Response {
        return Response::code200('controller stub response');
    }
}