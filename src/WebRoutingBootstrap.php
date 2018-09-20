<?php namespace Monolith\WebRouting;

use Monolith\ComponentLoading\ComponentBootstrap;
use Monolith\DependencyInjection\Container;
use Monolith\WebRouting\Methods;

class WebRoutingBootstrap implements ComponentBootstrap {

    public function bind(Container $container): void {

        $container->singleton(RouteDispatcher::class, function (Container $c) {

            return new MonolithRouteDispatcher($c);
        });
        
        $container->singleton(Router::class, function (Container $c) {

            return new Router($c[RouteCompiler::class], $c[RouteMatcher::class], $c[RouteDispatcher::class]);
        });
    }

    public function init(Container $container): void {

        /** @var Router $router */
        $router = $container[Router::class];
        $router->registerHandler(new Methods\GetMethod);
        $router->registerHandler(new Methods\PostMethod);
        $router->registerHandler(new Methods\FormMethod);
    }
}
