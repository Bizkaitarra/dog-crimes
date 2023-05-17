<?php

namespace App\Infrastructure\Game;

use App\Application\Game\FindGame;
use App\Application\Game\FindGamesIds;
use App\Domain\BoardPlace\Board;
use App\Domain\BoardPlace\BoardPlace;
use App\Domain\Dog\Dog;
use App\Domain\Dog\DogCollection;
use App\Domain\Game\Game;
use App\Domain\Rule\RuleCompliance;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

final class GameCommand extends Command
{
    public function __construct(
        private readonly FindGamesIds $findGamesIds,
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
            ->setName('dog-crimes:play')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Hola, voy a buscar un juego!');
        $gameIds = $this->findGamesIds->__invoke();
        $output->writeln(sprintf('Actualmente existen %s juegos', count($gameIds)));

        $game = $this->gameFinder->__invoke($gameIds[0]);
        $this->explainRules($game, $output);
        $this->explainWhereAreDogsPlaced($game, $output);

        while ($this->askForConfirmation($input, $output, '¿Quieres posicionar algún perro?')) {
            $selectedDog = $this->askForNewDogToBePlaced($input, $output,$game, $game->dogs);
            $selectedPlace = $this->askForNewPlace($input, $output,$game->board);
            $game->place($selectedDog, $selectedPlace->placeNumber);
            $this->explainWhereAreDogsPlaced($game, $output);
            $this->explainRules($game, $output);
            if ($game->isSolved()) {
                $output->writeln('El juego está solucionado, todas las reglas se cumplen y hay un perro posicionado en el lugar del crimen');
                $guilty = $game->dogThatMadeTheCrime();
                $output->writeln(sprintf('%s está delante de %s. ¿Qué has hecho %s',$guilty, $game->crime(), $guilty ));
                return Command::SUCCESS;
            }
        }
        $output->writeln('Una lástima, otro día seguiremos intentando buscar al culpable');

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

    private function askForConfirmation(
        InputInterface $input,
        OutputInterface $output,
        string $message
    ): bool {
        $helper = $this->getHelper('question');

        $question = new ChoiceQuestion(
            $message,
            ['Sí', 'No']
        );
        return $helper->ask($input, $output, $question) === 'Sí';
    }

    private function askForNewDogToBePlaced(
        InputInterface $input,
        OutputInterface $output,
        Game $game,
        DogCollection $dogs
    ): Dog {
        $helper = $this->getHelper('question');
        $question = new ChoiceQuestion(
            'Indica un perro',
            $dogs->toArray()
        );
        $question->setErrorMessage('%s no es un perro válido.');

        $dog = $helper->ask($input, $output, $question);
        $output->writeln('Has seleccionado a '.$dog);
        if (!$dog instanceof Dog) {
            $dog = $game->getDogByName($dog);
        }
        return $dog;
    }

    private function askForNewPlace(
        InputInterface $input,
        OutputInterface $output,
        Board $board
    ): BoardPlace {
        $helper = $this->getHelper('question');
        $question = new ChoiceQuestion(
            'Indica un lugar donde posicionar al perro',
            $board->toArray()
        );
        $question->setErrorMessage('%s no es un lugar válido.');

        $boardPlace = $helper->ask($input, $output, $question);
        $output->writeln('Has seleccionado a '.$boardPlace);
        return $boardPlace;
    }

    private function explainRules(Game $game, OutputInterface $output): void
    {
        foreach ($game->rules() as $ruleText => $ruleMeets) {
            $output->writeln($ruleText);
            switch ($ruleMeets) {
                case RuleCompliance::MeetsTheRule:
                    $output->writeln(sprintf('La regla "%s" se cumple', $ruleText));
                    break;
                case RuleCompliance::NotMeetNorViolateTheRule:
                    $output->writeln(sprintf('La regla "%s" no se cumple ni se incumple', $ruleText));
                    break;
                case RuleCompliance::ViolatesTheRule:
                    $output->writeln(sprintf('La regla "%s" se incumple', $ruleText));
                    break;
            }
        }

    }
}