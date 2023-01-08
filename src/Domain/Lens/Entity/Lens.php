<?php

namespace Shashin\Lens\Entity;

use Moody\ValueObject\Identity\Uuid;
use Shashin\Common\Entity\SerializableEntity;
use Shashin\Lens\ValueObject\FocalLenght;

class Lens extends SerializableEntity
{
    /**
     * @param Uuid        $id
     * @param string      $brand
     * @param string      $model
     * @param FocalLenght $minFocalLength
     * @param FocalLenght $maxFocalLength
     */
    public function __construct(
        protected Uuid $id,
        protected string $brand,
        protected string $model,
        protected FocalLenght $minFocalLength,
        protected FocalLenght $maxFocalLength,

    ) {
    }

    /**
     * @return Uuid
     */
    public function getId(): Uuid
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getBrand(): string
    {
        return $this->brand;
    }

    /**
     * @return string
     */
    public function getModel(): string
    {
        return $this->model;
    }

    /**
     * @return FocalLenght
     */
    public function getMinFocalLength(): FocalLenght
    {
        return $this->minFocalLength;
    }

    /**
     * @return FocalLenght
     */
    public function getMaxFocalLength(): FocalLenght
    {
        return $this->maxFocalLength;
    }
}