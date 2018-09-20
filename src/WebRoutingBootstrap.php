<?php namespace Monolith\WebRouting;

use Monolith\ComponentLoading\ComponentBootstrap;
use Monolith\DependencyInjection\Container;
use Monolith\WebRouting\Methods;

final class WebRoutingBootstrap implements ComponentBootstrap {

    public function bind(Container $container): void {

        $container->singleton(RouteDispatcher::class, function (Container $c) {

            return new RouteDispatcher($c);
        });

        $container->singleton(RouteCompiler::class);

        $container->singleton(Router::class, function (Container $c) {

            return new Router($c[RouteCompiler::class], $c[RouteMatcher::class], $c[RouteDispatcher::class]);
        });
    }

    public function init(Container $container): void {

        /** @var RouteCompiler $compiler */
        $compiler = $container[RouteCompiler::class];

        $compiler->registerMethodCompiler(new Methods\GetMethod);
        $compiler->registerMethodCompiler(new Methods\PostMethod);
        $compiler->registerMethodCompiler(new Methods\FormMethod);
    }
}
