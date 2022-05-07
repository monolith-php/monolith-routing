<?php namespace Monolith\WebRouting;

use Monolith\Http\Request;
use UnexpectedValueException;

final class CanNotMatchRoute extends UnexpectedValueException implements WebRoutingException
{
    public static function forRequest(Request $request): self
    {
        return new self(
            "Can not find a compatible route for request {$request->method()} . ' :: ' . {$request->uri()}."
        );
    }
}