<?php

namespace Shashin\Camera\Entity;

use Moody\ValueObject\Identity\Uuid;
use Shashin\Camera\Enum\CameraSensorSize;
use Shashin\Common\Entity\SerializableEntity;

class Camera extends SerializableEntity
{
    /**
     * @param Uuid             $id
     * @param string           $brand
     * @param string           $model
     * @param CameraSensorSize $sensorSize
     */
    public function __construct(
        protected Uuid $id,
        protected string $brand,
        protected string $model,
        protected CameraSensorSize $sensorSize
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
}