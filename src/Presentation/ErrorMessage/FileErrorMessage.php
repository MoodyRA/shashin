<?php

declare(strict_types=1);

namespace App\Presentation\ErrorMessage;

use App\Domain\Common\Enum\ErrorEnumInterface;
use App\Domain\File\Enum\FileError;

class FileErrorMessage extends AbstractErrorMessage
{
    /**
     * @param FileError $enum
     * @return string
     */
    public function get(ErrorEnumInterface $enum): string
    {
        switch ($this->lang) {
            case 'en':
                return $this->englishMessage($enum);
                break;
            case 'fr':
                return $this->frenchMessage($enum);
        }
    }

    /**
     * @param FileError $enum
     * @return string
     */
    private function englishMessage(ErrorEnumInterface $enum): string
    {
        return match ($enum) {
            FileError::FILE_NOT_FOUND => "File not found",
            FileError::FILE_MOVE_FAILED => "Failed to move file to file storage"
        };
    }

    /**
     * @param FileError $enum
     * @return string
     */
    private function frenchMessage(ErrorEnumInterface $enum): string
    {
        return match ($enum) {
            FileError::FILE_NOT_FOUND => "Fichier non trouvé",
            FileError::FILE_MOVE_FAILED => "Erreur lors du déplacement du fichier"
        };
    }
}