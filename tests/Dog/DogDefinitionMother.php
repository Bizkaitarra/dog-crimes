<?php

namespace App\Tests\Dog;

use App\Dog\Dog;
use App\Dog\DogDefinition;
use App\Game;
use PHPUnit\Framework\TestCase;

final class DogDefinitionMother
{
    public static function specificDogDefinition(Dog $dog): DogDefinition {
        return new DogDefinition(
            $dog->getName(),
            $dog->hasBandana(),
            $dog->hasTanTail(),
            $dog->hasPerkyEars(),
            $dog->hasWhitePaws(),
            $dog->hasCollar(),
            $dog->hasBow(),
        );
    }
    public static function definitionForTwoDog(Dog $firstDog, Dog $secondDog): DogDefinition {
        //We mock domain to make easy testing. This part of domain has it own test
        return new DogDefinitionStub([$firstDog->getName() => $firstDog, $secondDog->getName() => $secondDog]);
    }

    /**
     * @param string[] $dogNames
     * @return DogDefinition
     */
    public static function definitionForMultipleDogs(array $dogNames, Game $game): DogDefinition {
        //We mock domain to make easy testing. This part of domain has it own test
        $dogs = [];
        foreach ($dogNames as $dogName) {
            $dogs[] = $game->getDogByName($dogName);
        }
        return new DogDefinitionStub($dogs);
    }

    public static function notMeeteableDogDefinition(): DogDefinition {
        return new DogDefinition(
            'Incorrect dog',
            true,
            true,
            true,
            true,
            true,
            true,
        );
    }
}

class DogDefinitionStub extends DogDefinition {
    public function __construct(private array $dogs)
    {
    }

    public function getDogsThatMeets(array $dogs): array
    {
        return $this->dogs;
    }

}