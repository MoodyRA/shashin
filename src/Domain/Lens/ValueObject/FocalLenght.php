<?php

namespace Shashin\Lens\ValueObject;

use Shashin\Camera\Enum\CameraSensorSize;

class FocalLenght
{
    /**
     *
     * @param float                 $focalLenght
     * @param CameraSensorSize|null $sensorSize
     */
    public function __construct(
        // the focal lenght in mm
        private float $focalLenght,
        // if not provided, the sensor size is assumed to be full frame
        private ?CameraSensorSize $sensorSize = null
    ) {
        if ($this->sensorSize === null) {
            $this->sensorSize = CameraSensorSize::FullFrame;
        }

        $this->focalLenght = match ($this->sensorSize) {
            CameraSensorSize::FullFrame => $this->focalLenght,
            CameraSensorSize::APS_C => $this->focalLenght * 1.5,
            CameraSensorSize::MicroFourThirds => $this->focalLenght * 2,
        };
    }

    /**
     * @param CameraSensorSize $sensorSize
     * @param bool             $withSymbol
     * @return string
     */
    public function getValueFromSensorSize(CameraSensorSize $sensorSize, bool $withSymbol = false): string
    {
        $value = match ($sensorSize) {
            CameraSensorSize::FullFrame => $this->focalLenght,
            CameraSensorSize::APS_C => $this->focalLenght / 1.5,
            CameraSensorSize::MicroFourThirds => $this->focalLenght / 2,
        };
        if ($withSymbol) {
            $value .= 'mm';
        }
        return (string)$value;
    }

    /**=
     * @param bool $withSymbol
     * @return string
     */
    public function getFullFrameValue(bool $withSymbol = false): string
    {
        return $this->getValueFromSensorSize(CameraSensorSize::FullFrame, $withSymbol);
    }
}