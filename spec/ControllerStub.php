<?php namespace spec\Monolith\DependencyInjection;

use Monolith\HTTP\Response;

class ControllerStub {

    public function index(): Response {
        return new Response("hats");
    }
}