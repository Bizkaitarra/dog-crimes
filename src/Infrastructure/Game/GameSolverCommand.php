<?php

namespace App\Infrastructure\Game;

use App\Application\Game\FindGame;
use App\Application\Game\FindGamesIds;
use App\Domain\BoardPlace\Board;
use App\Domain\BoardPlace\BoardPlace;
use App\Domain\Dog\Dog;
use App\Domain\Dog\DogCollection;
use App\Domain\Game\Game;
use App\Domain\Game\GameId;
use App\Domain\Solver\BruteForceSolver;
use App\Domain\Solver\GameCantBeSolvedException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

final class GameSolverCommand extends Command
{
    public function __construct(
        private readonly FindGame $gameFinder
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            // the command help shown when running the command with the "--help" option
            ->setHelp('This command allows to play to dog crimes')
            ->setName('dog-crimes:solve')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $gameSolver = new BruteForceSolver();
        $game = $this->gameFinder->__invoke(new GameId(1));
        $this->explainRules($game, $output);

        try {
            $game = $gameSolver->__invoke($game);
            $output->writeln('Se ha resuelto el juego');
            $this->explainWhereAreDogsPlaced($game, $output);
        } catch (GameCantBeSolvedException) {
            $output->writeln('El juego no se puede resolver');
            return Command::SUCCESS;
        }
        return Command::SUCCESS;
    }

    public function explainWhereAreDogsPlaced(Game $game, OutputInterface $output): void
    {
        $placedDogs = $game->placedDogs();
        if ($placedDogs->empty()) {
            $output->writeln('No hay perros posicionados');
        }
        foreach ($placedDogs as $dog) {
            $output->writeln(
                sprintf(
                    '%s está posicionada en %s',
                    $dog->getName(),
                    $dog->getBoardPlace()->placeNumber
                )
            );
        }
    }

    private function explainRules(Game $game, OutputInterface $output): void
    {
        foreach ($game->rules() as $ruleText => $ruleMeets) {
            $output->writeln($ruleText);
            if ($ruleMeets) {
                $output->writeln(sprintf('La regla "%s" se cumple', $ruleText));
            } else {
                $output->writeln(sprintf('La regla "%s" se incumple', $ruleText));
            }
        }

    }
}