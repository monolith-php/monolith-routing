<?php namespace Monolith\WebRouting;

use function spec\Monolith\WebRouting\dd;

final class UriParameterParser
{
    public static function parseUriParameters($uri, $regex)
    {
        $parameters = [];
        preg_match($regex, $uri, $parameters);
        return static::stripNumericKeys($parameters);
    }

    private static function stripNumericKeys($parameters) {
        $new = $parameters;
        foreach($new as $k => $v) { if(is_int($k)) { unset($new[$k]); } }
        return $new;
    }
}