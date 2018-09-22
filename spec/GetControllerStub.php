<?php namespace spec\Monolith\WebRouting;

use Monolith\Http\Request;
use Monolith\Http\Response;
use Monolith\WebRouting\Methods\GetController;

final class GetControllerStub implements GetController {

    public function get(Request $request): Response {

        return Response::ok('get controller stub');
    }
}