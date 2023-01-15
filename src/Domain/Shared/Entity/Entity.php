<?php

declare(strict_types=1);

namespace Shashin\Shared\Entity;

use DateTime;
use Moody\ValueObject\Identity\Uuid;

abstract class Entity implements \JsonSerializable
{
    /** @var Uuid */
    protected Uuid $id;
    /** @var DateTime|null */
    protected ?DateTime $createdAt;
    /** @var DateTime|null */
    protected ?DateTime $updatedAt;

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

    /**
     * @return DateTime|null
     */
    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime|null $createdAt
     * @return Entity
     */
    public function setCreatedAt(?DateTime $createdAt): Entity
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime|null $updatedAt
     * @return Entity
     */
    public function setUpdatedAt(?DateTime $updatedAt): Entity
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}