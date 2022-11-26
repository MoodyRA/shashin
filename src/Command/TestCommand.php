<?php

namespace App\Command;

use Moody\ValueObject\DateTime\Date;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

// the "name" and "description" arguments of AsCommand replace the
// static $defaultName and $defaultDescription properties
#[AsCommand(
    name: 'pp:test-command',
    description: 'Test command.',
    aliases: ['app:test-command'],
    hidden: false
)]
class TestCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
       $date = new Date(2022,11,26);
        echo 'foo';
        return Command::SUCCESS;
    }

    protected function configure(): void
    {
        $this
            // the command help shown when running the command with the "--help" option
            ->setHelp('Test de la commande help');
    }
}