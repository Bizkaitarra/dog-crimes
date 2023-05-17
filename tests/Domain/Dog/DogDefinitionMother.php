<?php

namespace App\Tests\Domain\Dog;

use App\Domain\Dog\Dog;
use App\Domain\Dog\DogCollection;
use App\Domain\Dog\DogDefinition;
use App\Domain\Game\Game;

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
        return new DogDefinitionStub(new DogCollection([$firstDog->getName() => $firstDog, $secondDog->getName() => $secondDog]));
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
        return new DogDefinitionStub(new DogCollection($dogs));
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
    public function __construct(private DogCollection $dogs)
    {
    }

    public function getDogsThatMeets(DogCollection $dogs): DogCollection
    {
        return $this->dogs;
    }

}