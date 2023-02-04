<?php

namespace Shashin\Photo\UseCase\AddPhotos;

use Shashin\FileSystem\FileSystemInterface;
use Shashin\FileSystem\FileSystemMessage;
use Shashin\Photo\Collection\PhotoCollection;
use Shashin\Photo\Entity\Photo;
use Shashin\Photo\PhotoMessage;
use Shashin\Photo\Repository\PhotoRepository;
use Shashin\Shared\Error\ResponseError;
use Shashin\Shared\Exception\FileSystemException;
use Shashin\Shared\Exception\RepositoryException;

class AddPhotos
{
    /**
     * @param PhotoRepository     $photoRepository
     * @param FileSystemInterface $fileSystem
     */
    public function __construct(
        private readonly PhotoRepository $photoRepository,
        private readonly FileSystemInterface $fileSystem,
    ) {
    }

    /**
     * @param AddPhotosRequest   $request
     * @param AddPhotosPresenter $presenter
     * @return void
     */
    public function execute(AddPhotosRequest $request, AddPhotosPresenter $presenter): void
    {
        $response = new AddPhotosResponse();
        if ($this->addPhotosToFileSystem($request->getPhotos(), $response)) {
            try {
                // enregistrement des photos dans le système de stockage
                $this->photoRepository->bulkCreate($request->getPhotos());
            } catch (RepositoryException $e) {
                $error = new ResponseError(PhotoMessage::REPOSITORY_ERROR, [], $e);
                $response->addError($error);
            }
        } else {
            // en cas d'echec d'ajouts de photos sur le file system on rollback pour supprimer ceux éventuellement ajoutés avec succès
            $this->rollbackFileSystem($request->getPhotos(), $response);
        }

        $presenter->present($response);
    }

    /**
     * @param PhotoCollection   $photos
     * @param AddPhotosResponse $response
     * @return bool
     */
    private function addPhotosToFileSystem(PhotoCollection $photos, AddPhotosResponse $response): bool
    {
        /** @var Photo $photo */
        foreach ($photos as $photo) {
            $registeredFile = new \SplFileInfo(
                $this->fileSystem->getRootPath() .
                $this->fileSystem->getDirectorySeparator() .
                $photo->fileNameForFileSystem()
            );
            try {
                $this->fileSystem->add($photo->getFile(), $registeredFile);
                // si la photo a été ajouté avec succès sur le file system on met à jour le fichier de la photo
                // contenant le chemin définitif
                $photo->setFile($registeredFile);
            } catch (FileSystemException $e) {
                $response->addError(
                    new ResponseError(
                        FileSystemMessage::ERROR_ADD_FILE,
                        [
                            'source_file' => $photo->getFile()->getPathname(),
                            'destination_file' => $registeredFile->getPathname(),
                            'file_system_root_path' => $this->fileSystem->getRootPath(),
                        ],
                        $e
                    )
                );
                return false;
            }
        }
        return true;
    }

    /**
     * @param PhotoCollection   $photos
     * @param AddPhotosResponse $response
     * @return void
     */
    private function rollbackFileSystem(PhotoCollection $photos, AddPhotosResponse $response): void
    {
        /** @var Photo $photo */
        foreach ($photos as $photo) {
            try {
                if ($this->fileSystem->fileExists($photo->getFile())) {
                    $this->fileSystem->remove($photo->getFile());
                }
            } catch (FileSystemException $e) {
                $response->addError(
                    new ResponseError(
                        FileSystemMessage::ERROR_REMOVE_FILE,
                        [
                            'file' => $photo->getFile()->getPathname(),
                            'file_system_root_path' => $this->fileSystem->getRootPath(),
                        ],
                        $e
                    )
                );
            }
        }
    }
}