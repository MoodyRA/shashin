<?php

declare(strict_types=1);

namespace Shashin\Common\Entity;

use Moody\ValueObject\Identity\Uuid;

abstract class Entity implements \JsonSerializable
{
    /** @var Uuid */
    protected Uuid $id;

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }

    /**
     * @return Uuid
     */
    public function getId(): Uuid
    {
        return $this->id;
    }

    /**
     * @param Uuid $id
     * @return Entity
     */
    public function setId(Uuid $id): Entity
    {
        $this->id = $id;
        return $this;
    }
}