<?php namespace Monolith\WebRouting;

final class ReverseRouting
{
    public function route(CompiledRoutes $routes, $controllerClass, array $arguments = [])
    {
        /** @var CompiledRoute $matched */
        $matched = $routes->first(function (CompiledRoute $route) use ($controllerClass) {
            return $route->httpMethod() == 'get' && $route->controllerClass() == $controllerClass;
        });

        if ( ! $matched) {
            throw new CouldNotReverseRouteToGetMethodFromController($controllerClass);
        }

        return $this->parseArguments($matched->uri, $arguments);
    }

    private function parseArguments(string $uri, array $arguments)
    {
        $matches = [];
        preg_match_all('/\{.*?\}/', $uri, $matches);

        $matches = $matches[0];

        if (empty($matches)) {
            return $uri;
        }

        if (count($matches) != count($arguments)) {
            $matchString = implode(', ', $matches);
            $argumentsString = implode(', ', $arguments);
            throw new ReverseRoutingArgumentCountDoesntMatch("Failed to match ({$matchString}) to ({$argumentsString}).");
        }

        foreach (range(0, count($matches)-1) as $i) {
            $uri = str_replace($matches[$i], $arguments[$i], $uri);
        }

        return $uri;
    }
}