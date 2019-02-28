<?php namespace Monolith\WebRouting;

final class CompiledRoute
{
    /** @var string */
    private $httpMethod;
    /** @var string */
    private $regex;
    /** @var string */
    private $controllerClass;
    /** @var string */
    private $controllerMethod;
    /** @var Middlewares */
    private $middlewares;

    public function __construct(string $httpMethod, string $uri, string $controllerClass, string $controllerMethod, Middlewares $middlewares)
    {
        $this->httpMethod = strtolower($httpMethod);
        $this->uri = $uri;
        $this->regex = $this->routeRegexFromUriString($uri);
        $this->controllerClass = $controllerClass;
        $this->controllerMethod = $controllerMethod;
        $this->middlewares = $middlewares;
    }

    public function httpMethod(): string
    {
        return $this->httpMethod;
    }

    public function uri(): string
    {
        return $this->uri;
    }

    public function regex(): string
    {
        return $this->regex;
    }

    public function controllerClass(): string
    {
        return $this->controllerClass;
    }

    public function controllerMethod(): string
    {
        return $this->controllerMethod;
    }

    public function middlewares(): Middlewares
    {
        return $this->middlewares;
    }

    // this has to go to the matcher
    private function routeRegexFromUriString(string $uri): string
    {
        $regex = str_replace('/', '\/', $uri);

        $matches = [];
        preg_match_all('#(\{([\w\?]+)\})#', $regex, $matches, PREG_SET_ORDER);

        foreach ($matches as list($_, $var, $name)) {
            if (stristr($name, '?', -1)) {
                $name = substr($name, 0, strlen($name)-1);

                $regex = str_replace('/'.$var, "/?(?P<{$name}>[\w-]+)?", $regex);
            } else {
                $regex = str_replace($var, "(?P<{$name}>[\w-]+)", $regex);
            }
        }

        return "/^{$regex}\/?$/";
    }
}