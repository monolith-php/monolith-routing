<?php namespace Monolith\WebRouting;

class CompiledRoute {
    /** @var string */
    private $httpMethod;
    /** @var string */
    private $pattern;
    /** @var string */
    private $controllerClass;
    /** @var string */
    private $controllerMethod;

    protected function __construct(string $httpMethod, string $pattern, string $controllerClass, string $controllerMethod) {
        $this->httpMethod = strtoupper($httpMethod);
        $this->pattern = $pattern;
        $this->controllerClass = $controllerClass;
        $this->controllerMethod = $controllerMethod;
    }

    public static function GET(string $pattern, string $controllerClass, string $controllerMethod): CompiledRoute {
        return new CompiledRoute('GET', $pattern, $controllerClass, $controllerMethod);
    }

    public function httpMethod(): string {
        return $this->httpMethod;
    }

    public function regexPattern(): string {
        return $this->pattern;
    }

    public function controllerClass(): string {
        return $this->controllerClass;
    }

    public function controllerMethod(): string {
        return $this->controllerMethod;
    }
}