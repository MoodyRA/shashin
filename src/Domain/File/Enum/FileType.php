<?php

declare(strict_types=1);

namespace Shashin\File\Enum;

enum FileType: string
{
    case BMP = 'bmp';
    case GIF = 'gif';
    case JPEG = 'jpeg';
    case JPG = 'jpg';
    case PDF = 'pdf';
    case PNG = 'png';
    case TIF = 'tif';
    case TIFF = 'tiff';
    case WEBP = 'webp';

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
        return [self::BMP, self::GIF, self::JPEG, self::JPG, self::PNG, self::TIF, self::TIFF, self::WEBP];
    }

    /**
     * @return array<string>
     */
    public function imageTypeValues(): array
    {
        $values = [];
        foreach ($this->imageTypes() as $type) {
            $values[] = $type->value;
        }
        return $values;
    }

    /**
     * @return string
     */
    public function valueWithDot(): string
    {
        return '.' . $this->value;
    }

    /**
     * @param string $fileName
     * @return ?FileType
     */
    public static function fromFileName(string $fileName): ?FileType
    {
        return self::tryFrom(strtolower(pathinfo($fileName, PATHINFO_EXTENSION)));
    }
}