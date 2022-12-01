<?php

namespace App\Command;

use App\Domain\File\Enum\FileType;
use App\Domain\File\UseCase\MoveFileToStorage\MoveFileToStorage;
use App\Domain\File\UseCase\MoveFileToStorage\MoveFileToStorageRequest;
use App\Domain\Photo\Entity\Photo;
use App\Infrastructure\FileStorage\Local\LocalFileStorageAdapter;
use App\Presentation\File\MoveFileToStorage\MoveFileToStorageConsolePresenter;
use Moody\ValueObject\Identity\Uuid;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Exception\LogicException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
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
    /**
     * @param TranslatorInterface $translator
     * @throws LogicException
     */
    public function __construct(private TranslatorInterface $translator)
    {
        parent::__construct();
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $file = new Photo(
                Uuid::generate(),
                'myFile',
                FileType::fromFileName($input->getArgument('source')),
                ''
            );
            // chemin à récupérer plus tard par repo
            $useCase = new MoveFileToStorage(new LocalFileStorageAdapter('/home/shashin/data/gallery'));
            $useCase->execute(
                new MoveFileToStorageRequest($input->getArgument('source'), $file),
                $presenter = new MoveFileToStorageConsolePresenter($this->translator)
            );
            $output->setDecorated(true);
            foreach ($presenter->viewModel()->getNotifications() as $notification) {
                $message = $notification->getMessage();
                if ($output->getFormatter()->hasStyle($notification->getType()->value)) {
                    $type = $notification->getType()->value;
                    $message = "<$type>$message</$type>";
                }
                $output->writeln($message);
            }
        } catch (UnexpectedValueException | InvalidArgumentException $e) {
            echo $e->getMessage();
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