<?php namespace Monolith\WebRouting;

use DomainException;

final class CanNotReverseRoute extends DomainException implements WebRoutingException
{
    public static function fromController(
        string $controllerClass
    ): self {
        return new self(
            "Can not reverse route from controller, '$controllerClass'. No matching GET HTTP method route was specified."
        );
    }
}