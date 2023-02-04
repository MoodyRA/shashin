<?php

namespace Shashin\Photo\UseCase\AddPhotos;

interface AddPhotosPresenter
{
    /**
     * @param AddPhotosResponse $response
     * @return void
     */
    public function present(AddPhotosResponse $response): void;
}