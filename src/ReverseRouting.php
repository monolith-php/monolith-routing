<?php namespace Monolith\WebRouting;

use Monolith\Collections\Collection;

final class ReverseRouting
{
    public function route(
        CompiledRoutes $routes,
        $controllerClass,
        array $arguments = []
    ): string {
        /** @var CompiledRoute $matched */
        $matched = $routes->first(
            fn(CompiledRoute $route) => $route->httpMethod() == 'get'
                && $route->controllerClass() == $controllerClass
        );

        if ( ! $matched) {
            throw CanNotReverseRoute::fromController($controllerClass);
        }

        return $this->parseArguments($matched->uri, $arguments);
    }

    private function parseArguments(
        string $uri,
        array $arguments
    ): string {
        # 1. match required fields
        # 2. match optional fields
        # 3. return valid url

        # arguments are the parameters that are used as the variables
        # in a uri. if the route looks like /article/{id}/{another} and in use
        # it would look like /article/123/234 then the first argument is
        # 123 and the second is 234
        $arguments = new Collection($arguments);

        # field matchers look like {this} and are required unless
        # they look like {this?}
        $allFieldMatchers = [];
        preg_match_all('/\{.*?\}/', $uri, $allFieldMatchers);
        $allFieldMatchers = new Collection($allFieldMatchers[0]);

        # if no fields must be matched simply return the uri
        if (empty($allFieldMatchers)) {
            return $uri;
        }

        $requiredMatchers = $allFieldMatchers->filter(function ($matcher) {
            $matches = [];
            preg_match("/[^?]\}$/", $matcher, $matches);
            return ! empty($matches);
        });

        $optionalMatchers = $allFieldMatchers->filter(function ($matcher) {
            return stristr($matcher, '?}');
        });

        # apply required matchers
        $uri = $this->applyRequiredMatchers($uri, $requiredMatchers, $arguments);

        # apply optional matchers
        $uri = $this->applyOptionalMatchers($uri, $optionalMatchers, $arguments);

        # if empty, need to have a /
        return $uri ?: '/';
    }

    private function applyRequiredMatchers(
        string $uri,
        Collection $requiredMatchers,
        Collection $arguments
    ) {
        if ($requiredMatchers->count() > $arguments->count()) {
            $matchString = $requiredMatchers->implode(', ');
            $argumentsString = $arguments->implode(', ');

            throw CanNotMatchReverseRoutingRequiredMatchers::argumentCountDoesntMatch($matchString, $argumentsString);
        }

        return $requiredMatchers
            ->zip($arguments)
            ->reduce(function ($key, $args, $uri) {
                [$matcher, $argument] = $args;
                if (is_null($matcher)) {
                    return $uri;
                }
                return str_replace($matcher, $argument, $uri);
            }, $uri);
    }

    private function applyOptionalMatchers(
        $uri,
        Collection $optionalMatchers,
        Collection $arguments
    ): string {
        $uri = $optionalMatchers
            ->zip($arguments)
            ->reduce(function ($key, $args, $uri) {
                [$matcher, $argument] = $args;
                return str_replace($matcher ?? '', $argument ?? '', $uri);
            }, $uri);

        return rtrim($uri, '/');
    }
}