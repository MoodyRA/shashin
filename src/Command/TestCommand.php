<?php

namespace App\Command;

use Shashin\File\Entity\File;
use Shashin\File\Enum\FileType;
use Shashin\Photo\Entity\Photo;
use App\Infrastructure\FileStorage\Local\LocalFileStorageAdapter;
use App\Infrastructure\FileStorage\PathPrefixer;
use Moody\ValueObject\Identity\Uuid;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use UnexpectedValueException;

// the "name" and "description" arguments of AsCommand replace the
// static $defaultName and $defaultDescription properties
#[AsCommand(
    name: 'app:test-command',
    description: 'Test command.',
    aliases: ['app:test-command'],
    hidden: false
)]
class TestCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $source = '/home/shashin/data/upload/chateau_ambulant.jpg';
            $source2 = '/home/shashin/data/upload/IMG_20220730_230613.jpg';
            $type = FileType::fromFileName($source);
            $storage = new LocalFileStorageAdapter('/home/shashin/data/gallery');
            $file = new File(Uuid::generate(), 'myFile', $type, '');
            $storage->move($source, $file);
            $storage->move($source2, $file);
        } catch (UnexpectedValueException $e) {
            echo $e->getMessage();
        }

        return Command::SUCCESS;
    }

    protected function configure(): void
    {
        $this
            // the command help shown when running the command with the "--help" option
            ->setHelp('Test de la commande help');
    }
}