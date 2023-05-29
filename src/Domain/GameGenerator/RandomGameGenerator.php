<?php

namespace App\Domain\GameGenerator;

use App\Domain\Crime;
use App\Domain\Dog\Dog;
use App\Domain\Dog\DogDefinition;
use App\Domain\Game\Game;
use App\Domain\Rule\DogAcrossToDogRule;
use App\Domain\Rule\DogLeftToDogRule;
use App\Domain\Rule\DogNextToDogRule;
use App\Domain\Rule\DogRightToDogRule;
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
                    $lastNumberOfSolutions = $solutions;
                    $rules[] = $rule;
                    echo 'Current number of rules: ' . count($rules) . PHP_EOL;
                }

            } catch (GameCantBeSolvedException $exception) {
                echo $exception->getMessage() . PHP_EOL;
            }
        }
        return $game;
    }

    private function randomRule(): Rule
    {
        switch (rand(0, 3)) {
            case 0:
                return $this->randomDogAcrossToDogRule(DogAcrossToDogRule::class);
            case 1:
                return $this->randomDogAcrossToDogRule(DogLeftToDogRule::class);
            case 2:
                return $this->randomDogAcrossToDogRule(DogRightToDogRule::class);
            case 3:
                return $this->randomDogAcrossToDogRule(DogNextToDogRule::class);
        }
        throw new \LogicException('This should not happen');
    }

    private function randomDogAcrossToDogRule(string $className): TwoDogPlaced
    {
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

    private function randomDogName() {
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


}