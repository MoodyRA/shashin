<?php

declare(strict_types=1);

namespace App\Presentation\ErrorMessage;

use App\Domain\Common\Enum\ErrorEnumInterface;

abstract class AbstractErrorMessage
{
    public function __construct(protected string $lang = 'en')
    {
    }

    /**
     * @param ErrorEnumInterface $enum
     * @return string
     */
    public abstract function get(ErrorEnumInterface $enum): string;
}