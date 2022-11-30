<?php

namespace App\Command;

use App\Domain\File\Entity\File;
use App\Domain\File\Enum\FileType;
use App\Domain\File\UseCase\MoveFileToStorage\MoveFileToStorage;
use App\Domain\File\UseCase\MoveFileToStorage\MoveFileToStorageRequest;
use App\Domain\Photo\Entity\Photo;
use App\Infrastructure\FileStorage\Local\LocalFileStorageAdapter;
use App\Infrastructure\FileStorage\PathPrefixer;
use App\Presentation\File\MoveFileToStorage\MoveFileToStorageConsolePresenter;
use Moody\ValueObject\Identity\Uuid;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use UnexpectedValueException;

// the "name" and "description" arguments of AsCommand replace the
// static $defaultName and $defaultDescription properties
#[AsCommand(
    name: 'file:move',
    description: 'Move a file to a file storage.',
    aliases: ['file:move'],
    hidden: false
)]
class MoveFileToStorageCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $storage = new LocalFileStorageAdapter('/home/shashin/data/gallery');
            $source = $input->getArgument('source');
            $type = FileType::fromFileName($source);
            $file = new Photo(Uuid::generate(), 'myFile', $type, '');
            $useCase = new MoveFileToStorage($storage);
            $request = new MoveFileToStorageRequest($source, $file);
            $presenter = new MoveFileToStorageConsolePresenter('fr');
            $useCase->execute($request, $presenter);
            $model = $presenter->viewModel();

            $formatter = $this->getHelper('formatter');
            $output->setDecorated(true);
            foreach ($model->getNotifications() as $notification) {
                $output->writeln($formatter->formatBlock($notification->getMessage(), $notification->getType()->value));
            }
        } catch (UnexpectedValueException $e) {
            echo $e->getMessage();
        } catch (InvalidArgumentException $e) {
        }

        return Command::SUCCESS;
    }

    protected function configure(): void
    {
        $this
            // configure an argument
            ->addArgument('source', InputArgument::REQUIRED, 'The source path of the file to move.')// ...
        ;
    }
}