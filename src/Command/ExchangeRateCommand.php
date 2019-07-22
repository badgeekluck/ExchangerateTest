<?php

namespace App\Command;

use App\Controller\ExchangeRateController;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpClient\HttpClient;

class ExchangeRateCommand extends Command
{
    protected static $defaultName = 'exchange:Rate';

    protected function configure()
    {
        $this
            ->setDescription('Return ExchangeRate as JSON')
            ->addArgument('url', InputArgument::REQUIRED, 'URL for getting exchange data')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $url = $input->getArgument('url');

        if ( $input->getArgument('url') ) {

            $insertToDb = new ExchangeRateController();
            $httpClient = HttpClient::create();

            $response = $httpClient->request('GET', $url);
            $contents = $response->toArray();

            $insertToDb->insertToDb($contents);

            $io->write($contents);
        }
    }
}
