<?php namespace Monolith\WebRouting;

use ArrayAccess;
use Monolith\Collections\Map;

final class Parameters extends Map implements ArrayAccess {

    public function offsetExists($offset): bool {
        return $this->has($offset);
    }

    public function offsetGet($offset) {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value) {
        throw new \RuntimeException("Parameters are immutable. Could not set item: {$offset}.");
    }

    public function offsetUnset($offset) {
        throw new \RuntimeException("Parameters are immutable. Could not unset item: {$offset}.");
    }
}