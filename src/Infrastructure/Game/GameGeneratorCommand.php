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
use App\Domain\GameGenerator\RandomGameGenerator;
use App\Domain\Solver\BruteForceSolver;
use App\Domain\Solver\GameCantBeSolvedException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

final class GameGeneratorCommand extends Command
{
    protected function configure(): void
    {
        $this
            // the command help shown when running the command with the "--help" option
            ->setHelp('This command generates a random game dog crimes')
            ->setName('dog-crimes:generate')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $gameSolver = new BruteForceSolver();
        $gameGenerator = new RandomGameGenerator($gameSolver);
        $game = $gameGenerator->__invoke();
        $this->explainRules($game, $output);
        $this->explainWhereAreDogsPlaced($game, $output);
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