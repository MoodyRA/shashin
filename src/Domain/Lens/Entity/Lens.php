<?php

namespace Shashin\Lens\Entity;

use Moody\ValueObject\Identity\Uuid;
use Shashin\Shared\Entity\Entity;
use Shashin\Lens\ValueObject\FocalLenght;

class Lens extends Entity
{
    /**
     * @param Uuid        $id
     * @param string      $brand
     * @param string      $model
     * @param FocalLenght $minFocalLength
     * @param FocalLenght $maxFocalLength
     */
    public function __construct(
        Uuid $id,
        protected string $brand,
        protected string $model,
        protected FocalLenght $minFocalLength,
        protected FocalLenght $maxFocalLength,

    ) {
        $this->setId($id);
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