<?php namespace Monolith\Routing;

use App\Web\Routes;

interface RouteDeclaration {
    public function define(Routes $r): void;
}