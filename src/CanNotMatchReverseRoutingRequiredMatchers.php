<?php namespace Monolith\WebRouting;

use DomainException;

final class CanNotMatchReverseRoutingRequiredMatchers extends DomainException implements WebRoutingException
{
    public static function argumentCountDoesntMatch(
        string $matchString,
        string $argumentsString
    ): self {
        return new self(
            "Can not match reverse routing required matchers, matching '$matchString' to '$argumentsString'."
        );
    }
}