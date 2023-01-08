<?php

namespace Shashin\Photo\Model;

class Exposure
{
    /** @var float */
    private float $aperture;
    /** @var int */
    private int $iso;
    /** @var int */
    private int $shutterSpeed;

    /**
     * @param float $aperture
     * @param int   $iso
     * @param int   $shutterSpeed
     */
    public function __construct(float $aperture, int $iso, int $shutterSpeed)
    {
        $this->aperture = $aperture;
        $this->iso = $iso;
        $this->shutterSpeed = $shutterSpeed;
    }

    /**
     * @return float
     */
    public function getAperture(): float
    {
        return $this->aperture;
    }

    /**
     * @return int
     */
    public function getIso(): int
    {
        return $this->iso;
    }

    /**
     * @return int
     */
    public function getShutterSpeed(): int
    {
        return $this->shutterSpeed;
    }
}