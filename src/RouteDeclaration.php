<?php namespace Monolith\Routing;

interface RouteDeclaration {
    public function define(): RouteCollection;
}