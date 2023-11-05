<?php

namespace App\Domain\GameGenerator;

use App\Domain\Crime;
use App\Domain\Dog\Dog;
use App\Domain\Dog\DogDefinition;
use App\Domain\Evidence;
use App\Domain\Game\Game;
use App\Domain\Rule\DogAcrossToDogRule;
use App\Domain\Rule\DogLeftToDogRule;
use App\Domain\Rule\DogNextToDogRule;
use App\Domain\Rule\DogPlacedInAPlaceWithCrime;
use App\Domain\Rule\DogPlacedInAPlaceWithEvidence;
use App\Domain\Rule\DogRightToDogRule;
use App\Domain\Rule\DogsWherePlayingOutside;
use App\Domain\Rule\Rule;
use App\Domain\Rule\TwoDogPlaced;
use App\Domain\Solver\BruteForceSolver;
use App\Domain\Solver\GameCantBeSolvedException;

final class RandomGameGenerator
{

    public function __construct(private readonly BruteForceSolver $bruteForceSolver)
    {
    }

    public function __invoke(): Game
    {
        $rules = [];
        $crime = Crime::CAKE;
        $gameWithOnlyOneSolution = false;
        $lastNumberOfSolutions = 9999999999999;
        $game = null;
        while (!$gameWithOnlyOneSolution) {
            $rule = $this->randomRule();
            $game = new Game(array_merge($rules, [$rule]), $crime);
            try {
                $solutions = $this->bruteForceSolver->__invoke($game)->count();
                if ($solutions === 1) {
                    $gameWithOnlyOneSolution = true;
                } else {
                    echo 'Game with ' . $solutions . ' solutions' . PHP_EOL;
                }

                if ($lastNumberOfSolutions > $solutions) {
                    $rules[] = $rule;
                    echo 'Current number of rules: ' . count($rules) . PHP_EOL;
                } elseif ($lastNumberOfSolutions === 2) {
                    echo 'Current number of rules: ' . count($rules) . PHP_EOL;
                    unset($rules[array_rand($rules)]);
                }
                $lastNumberOfSolutions = $solutions;

            } catch (GameCantBeSolvedException $exception) {
                echo $exception->getMessage() . PHP_EOL;
            }
        }

        if ($game === null) {
            throw new \LogicException('This should not happen');
        }
        echo 'Se ha conseguido crear un juego! ' . PHP_EOL;
        return $game;
    }

    private function randomRule(): Rule
    {
        switch (rand(0, 6)) {
            case 0:
                return $this->randomDogAcrossToDogRule(DogAcrossToDogRule::class);
            case 1:
                return $this->randomDogAcrossToDogRule(DogLeftToDogRule::class);
            case 2:
                return $this->randomDogAcrossToDogRule(DogRightToDogRule::class);
            case 3:
                return $this->randomDogAcrossToDogRule(DogNextToDogRule::class);
            case 4:
                return $this->randomDogsWherePlayingOutside();
            case 5:
                return $this->randomDogPlacedInAPlaceWithEvidence();
            case 6:
                return $this->randomDogPlacedInAPlaceWithCrime();
        }
        throw new \LogicException('This should not happen');
    }

    private function randomDogAcrossToDogRule(string $className): TwoDogPlaced
    {
        if (!is_subclass_of($className, TwoDogPlaced::class)) {
            throw new \InvalidArgumentException("$className must be a subclass of TwoDogPlaced");
        }
        $firstDogDefinition = $this->randomDogDefinition();
        $secondDogDefinition = $this->randomDogDefinition();

        return new $className(
            'El perro %s está enfrente del perro %s',
            $firstDogDefinition,
            $secondDogDefinition
        );
    }

    private function randomDogDefinition(): DogDefinition
    {
        switch (rand(0, 6)) {
            case 0:
                return new DogDefinition($this->randomDogName(), null, null, null, null, null, null);
            case 1:
                return new DogDefinition(null, true, null, null, null, null, null);
            case 2:
                return new DogDefinition(null, null, true, null, null, null, null);
            case 3:
                return new DogDefinition(null, null, null, true, null, null, null);
            case 4:
                return new DogDefinition(null, null, null, null, true, null, null);
            case 5:
                return new DogDefinition(null, null, null, null, null, true, null);
            case 6:
                return new DogDefinition(null, null, null, null, null, null, true);
        }
        throw new \LogicException('This should not happen');
    }

    private function randomDogName(): string {
        switch (rand(0, 5)) {
            case 0:
                return Dog::SUZETTE;
            case 1:
                return Dog::PEPPER;
            case 2:
                return Dog::BEANS;
            case 3:
                return Dog::DAISY;
            case 4:
                return Dog::ACE;
            case 5:
                return Dog::CIDER;
        }
        throw new \LogicException('This should not happen');
    }

    private function randomDogsWherePlayingOutside(): DogsWherePlayingOutside
    {
        return new DogsWherePlayingOutside(
            'Los perros %s y %s estaban jugando fuera',
            [$this->randomDogDefinition()]
        );
    }

    private function randomDogPlacedInAPlaceWithEvidence(): DogPlacedInAPlaceWithEvidence
    {

        return new DogPlacedInAPlaceWithEvidence(
            'El perro %s estaba en el lugar %s',
            $this->randomDogDefinition(),
            $this->randomEvidence()
        );
    }

    private function randomCrime(): Crime {
        switch (rand(0, 5)) {
            case 0:
                return new Crime(Crime::CAKE, true);
            case 1:
                return new Crime(Crime::POOP, true);
            case 2:
                return new Crime(Crime::FLOWER_POT, true);
            case 3:
                return new Crime(Crime::HOMEWORK, true);
            case 4:
                return new Crime(Crime::PILLOW, true);
            case 5:
                return new Crime(Crime::SHOES, true);
        }
        throw new \LogicException('This should not happen');
    }

    private function randomEvidence(): Evidence {
        switch (rand(0, 5)) {
            case 0:
                return new Evidence(Evidence::ROPE_TOY);
            case 1:
                return new Evidence(Evidence::TENNIS_BALL);
            case 2:
                return new Evidence(Evidence::SOCK);
            case 3:
                return new Evidence(Evidence::LEATHER_BONE);
            case 4:
                return new Evidence(Evidence::STICK);
            case 5:
                return new Evidence(Evidence::PAW_PRINT);
        }
        throw new \LogicException('This should not happen');
    }

    private function randomDogPlacedInAPlaceWithCrime(): DogPlacedInAPlaceWithCrime
    {
        return new DogPlacedInAPlaceWithCrime(
            'El perro %s estaba en el lugar %s',
            $this->randomDogDefinition(),
            $this->randomCrime()
        );
    }


}