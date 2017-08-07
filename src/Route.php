<?php namespace Monolith\WebRouting;

interface Route {
    public function identifier(): string;
    public function uri(): string;
    public function controller();
}