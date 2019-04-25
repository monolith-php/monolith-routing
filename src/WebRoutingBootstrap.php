<?php namespace Monolith\WebRouting;

use Monolith\ComponentBootstrapping\ComponentBootstrap;
use Monolith\DependencyInjection\Container;
use Monolith\WebRouting\Methods;

final class WebRoutingBootstrap implements ComponentBootstrap
{
    public function bind(Container $container): void
    {
        $container->singleton(RouteDispatcher::class, function ($r) {
            return new RouteDispatcher($r(Container::class));
        });

        $container->singleton(RouteCompiler::class);

        $container->singleton(Router::class, function ($r) {
            return new Router(
                $r(RouteCompiler::class),
                $r(RouteMatcher::class),
                $r(RouteDispatcher::class),
                new ReverseRouting
            );
        });
    }

    public function init(Container $container): void
    {
        /** @var RouteCompiler $compiler */
        $compiler = $container->get(RouteCompiler::class);

        $compiler->registerMethodCompiler(new Methods\GetMethod);
        $compiler->registerMethodCompiler(new Methods\PostMethod);
        $compiler->registerMethodCompiler(new Methods\FormMethod);
        $compiler->registerMethodCompiler(new Methods\PathMapMethod);
    }
}
