<?php

namespace MarcoKretz\AdventOfCode2023\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SolverCommand extends Command
{
    protected static $defaultName = 'solve';

    protected function configure(): void
    {
        $this
            ->setDescription('Solve the puzzles of Advent of Code 2023')
            ->addArgument('day', null, 'The day to solve', null);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $day = $input->getArgument('day');
        if ($day === null) {
            $output->writeln('Please provide a day to solve');
            return Command::FAILURE;
        }

        $solverClass = 'MarcoKretz\\AdventOfCode2023\\Day' . $day . '\\Solver';
        if (!class_exists($solverClass)) {
            $output->writeln('No solver found for day ' . $day);
            return Command::FAILURE;
        }

        $solver = new $solverClass();

        $solver->solve();

        return Command::SUCCESS;
    }
}
