<?php namespace Monolith\WebRouting;

use UnexpectedValueException;

final class CanNotCompileRoute extends UnexpectedValueException implements WebRoutingException
{
    public static function noCompilerForMethod(string $method): self
    {
        return new self(
            "Can not compile route. No compiler was found for method '$method'."
        );
    }
}