<?php namespace Monolith\WebRouting;

final class RouteGroup {

//    /** @var Routes */
//    private $routes;
//
//    public function __construct(Routes $routes) {
//
//        $this->routes = $routes;
//    }
//
//    public function flatten() {
//
//        // flatten all child items
//        $flat = $this->flatMap(function ($route) {
//
//            if ($route instanceof RouteGroup) {
//                return $route->flatten();
//            }
//
//            return $route;
//        }, $this->routes);
//
//        // flatten resulting items into us
//        return $this->routes->merge($flat);
//    }
//
//    private function flatMap(callable $f): Routes {
//
//        return $this->routes->map($f);
//    }
}