<?php

namespace Shashin\Shared\Trait;

trait SerializableObject
{
    /**
     * @return array
     */
    public function serialize(): array
    {
        return get_object_vars($this);
    }
}