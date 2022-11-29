<?php

declare(strict_types=1);

namespace App\Domain\File\Enum;

enum FileType: string
{
    case JPEG = 'jpeg';
    case PNG = 'png';
    case PDF = 'pdf';

    /**
     * @return bool
     */
    public function isImageType(): bool
    {
        $isImage = false;
        if (in_array($this, $this->imageTypes())) {
            $isImage = true;
        }
        return $isImage;
    }

    /**
     * @return FileType[]
     */
    public function imageTypes(): array
    {
        return [self::JPEG, self::PNG];
    }

    /**
     * @return array
     */
    public function imageTypeValues(): array
    {
        return [self::JPEG->value, self::PNG->value];
    }
}