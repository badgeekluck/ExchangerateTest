<?php

namespace App\Command;

use App\Controller\ExchangeRateController;
use App\Entity\ExchangeRate;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;


class ExchangeRateCommand extends Command
{
    protected static $defaultName = 'exchange:Rate';

    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->container = $container;
    }

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
        $em = $this->container->get('doctrine')->getManager();
        $url = $input->getArgument('url');
        $exChange = new ExchangeRate();


        if ( $input->getArgument('url') ) {

            $httpClient = HttpClient::create();

            $response = $httpClient->request('GET', $url);
            $contents = $response->toArray();

            foreach ($contents as $key => $value) {

                $exChange->setValue($value[0]['amount']);
                $exChange->setCurrencyUnit($value[0]['symbol']);

                $em->persist($exChange);
                $em->flush();

            }

            $io->write($contents);
        }
    }
}
