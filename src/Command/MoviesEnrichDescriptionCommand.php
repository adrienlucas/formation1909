<?php

namespace App\Command;

use App\Repository\MovieRepository;
use App\Service\OmdbGateway;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:movies:enrich-description',
    description: 'Add a short description for your command',
)]
class MoviesEnrichDescriptionCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private MovieRepository $movieRepository,
        private OmdbGateway $omdbGateway,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
//        $this
//            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
//            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
//        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $io = new SymfonyStyle($input, $output);

        $emptyDescriptionMovies = $this->movieRepository->findEmptyDescriptions();

        $io->progressStart(count($emptyDescriptionMovies));

        foreach($emptyDescriptionMovies as $emptyDescriptionMovie) {
            $description = $this->omdbGateway->getDescriptionByMovie($emptyDescriptionMovie);
            $emptyDescriptionMovie->setDescription($description);
            $io->progressAdvance();
        }

        $this->entityManager->flush();
        $io->progressFinish();

//        $arg1 = $input->getArgument('arg1');
//
//        if ($arg1) {
//            $io->note(sprintf('You passed an argument: %s', $arg1));
//        }
//
//        if ($input->getOption('option1')) {
//            // ...
//        }
//
//        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
