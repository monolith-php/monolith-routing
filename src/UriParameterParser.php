<?php namespace Monolith\WebRouting;

final class UriParameterParser
{
    public static function parseUriParameters($uri, $regex)
    {
        $parameters = [];
        preg_match($regex, $uri, $parameters);
        return self::stripNumericKeys($parameters);
    }

    private static function stripNumericKeys($parameters)
    {
        $new = $parameters;
        
        foreach ($new as $k => $v) {
            if (is_int($k)) {
                unset($new[$k]);
            }
        }
        
        return $new;
    }
}