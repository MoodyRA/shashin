<?php

declare(strict_types=1);

namespace Shashin\Common\Entity;

abstract class SerializableEntity implements \JsonSerializable
{
    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}