<?php

declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Service\FetchFruitsService;
use App\Service\FruitManagerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Message\AdminAlertNotification;

#[AsCommand(name: 'fruits:fetch')]
class FetchFruitsCommand extends Command
{
    public function __construct(
        private readonly FetchFruitsService $fruitFetcher,
        private readonly FruitManagerInterface $fruitManager,
        private readonly MessageBusInterface $bus,
        private readonly AdminAlertNotification $message
    )
    {
        parent::__construct();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln(['=================================', 'Fetching data from the Fruits API']);
        $data = $this->fruitFetcher->fetchAllFruits();

        $output->writeln(['=================================', 'Filling data to the database']);
        $this->fruitManager->createManyFruits($data);

        $output->writeln(['=================================', 'Sending alert']);
        $this->bus->dispatch($this->message->setBody('Database filled successfully'));

        $output->writeln(['=================================', 'SUCCESS']);

        return Command::SUCCESS;
    }
}
