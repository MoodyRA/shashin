<?php

namespace Shashin\Photo\Service;

class ExifReader
{
    /** @var array */
    private array $rowData = [];

    /**
     * Initialise un tableau contenant les données EXIF d'un fichier.
     *
     * @param string $file
     */
    public function __construct(string $file)
    {
        $exif = @exif_read_data($file, 'EXIF');
        if ($exif !== false) {
            $this->rowData = $exif;
        }
    }

    /**
     * @return float|null
     */

    public function getFocalLength(): ?float
    {
        if (isset($this->rowData['FocalLength'])) {
            return $this->getFloatFromValue($this->rowData['FocalLength']);
        }
        return null;
    }

    /**
     * Renvoie la valeur d'une clé EXIF sous forme de float, cela permet notamment de gérer les valeurs de type 'a/b'.
     *
     * @param string $value
     * @return float
     */
    private function getFloatFromValue(string $value): float
    {
        $pos = strpos($value, '/');

        if ($pos === false) {
            return (float)$value;
        }

        $a = (float)substr($value, 0, $pos);

        $b = (float)substr($value, $pos + 1);

        return ($b == 0) ? ($a) : ($a / $b);
    }
}