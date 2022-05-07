<?php namespace Monolith\WebRouting;

use UnexpectedValueException;

final class CanNotDispatchRoute extends UnexpectedValueException implements WebRoutingException
{
    public static function unableToResolveControllerClass(
        string $controllerClass
    ): self {
        return new self(
            "Can not dispatch route. Unable to resolve controller class '$controllerClass'."
        );
    }
}