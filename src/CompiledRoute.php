<?php namespace Monolith\WebRouting;

final class CompiledRoute {

    /** @var string */
    private $httpMethod;
    /** @var string */
    private $regex;
    /** @var string */
    private $controllerClass;
    /** @var string */
    private $controllerMethod;

    public function __construct(string $httpMethod, string $uri, string $controllerClass, string $controllerMethod) {
        $this->httpMethod       = strtolower($httpMethod);
        $this->regex            = $this->transformUriStringToRegex($uri);
        $this->controllerClass  = $controllerClass;
        $this->controllerMethod = $controllerMethod;
    }

    public function httpMethod(): string {
        return $this->httpMethod;
    }

    public function regex(): string {
        return $this->regex;
    }

    public function controllerClass(): string {
        return $this->controllerClass;
    }

    public function controllerMethod(): string {
        return $this->controllerMethod;
    }

    private function transformUriStringToRegex(string $uri): string {

        $regex = str_replace('/', '\/', $uri);

        $matches = [];
        preg_match_all('#(\{(\w+)\})#', $regex, $matches, PREG_SET_ORDER);

        foreach ($matches as list($_, $var, $name)) {
            $regex = str_replace($var, "(?P<{$name}>[\w-]+)", $regex);
        }

        return "/^{$regex}\/?$/";
    }
}