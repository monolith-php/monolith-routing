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
        $this->httpMethod       = strtoupper($httpMethod);
        $this->regex            = $this->parseUriToRegex($uri);
        $this->controllerClass  = $controllerClass;
        $this->controllerMethod = $controllerMethod;
    }

    public static function GET(string $uri, string $controllerClass, string $controllerMethod): CompiledRoute {
        return new CompiledRoute('GET', $uri, $controllerClass, $controllerMethod);
    }

    public static function POST(string $uri, string $controllerClass, string $controllerMethod): CompiledRoute {
        return new CompiledRoute('POST', $uri, $controllerClass, $controllerMethod);
    }

    public function httpMethod(): string {
        return $this->httpMethod;
    }

    public function regex(): string {
        return $this->regex;
    }

    public function controllerName(): string {
        return $this->controllerClass;
    }

    public function controllerMethod(): string {
        return $this->controllerMethod;
    }

    private function parseUriToRegex(string $uri): string {
        $regex = str_replace('/', '\/', $uri);
        $matches = [];
        preg_match_all('#(\{(\w+)\})#', $regex, $matches, PREG_SET_ORDER);
        foreach ($matches as list($_, $var, $name)) {
            $regex = str_replace($var, "(?P<{$name}>\w+)", $regex);
        }
        return "/^{$regex}$/";
    }
}