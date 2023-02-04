<?php

namespace Shashin\Photo\UseCase\AddPhotos;

use Shashin\File\FileSystemException;
use Shashin\File\FileSystemInterface;
use Shashin\Photo\Repository\PhotoRepository;
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
        foreach ($request->getPhotos()->all() as $photo) {
            $registeredFile = new \SplFileInfo(
                $this->fileSystem->getRootPath() . DIRECTORY_SEPARATOR . $photo->fileSystemFileName()
            );
            try {
                $this->fileSystem->add($photo->getFile(), $registeredFile);
                // si la photo a été ajouté avec succès sur le file system on met à jour le fichier de la photo
                // contenant le chemin définitif
                $photo->setFile($registeredFile);
                // enregistrement de la photo dans le système de stockage
                $this->photoRepository->create($photo);
            } catch (FileSystemException $e) {
                // todo : erreur lors de l'ajout sur file system
            } catch (\UnexpectedValueException $e) {
                // todo : le fichier n'a pas été trouvé lors du setFile()
            } catch (RepositoryException $e) {
                // todo : erreur lors de la création dans le système de stockage
            }
        }

        $presenter->present($response);
    }
}