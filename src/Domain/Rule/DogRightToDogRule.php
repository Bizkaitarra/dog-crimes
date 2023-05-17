<?php

namespace App\Domain\Rule;

use App\Domain\Dog\Dog;
use App\Domain\Dog\DogDefinition;

class DogRightToDogRule extends TwoDogPlaced
{

    public function __construct(
        private readonly string        $ruleText,
        private readonly DogDefinition $firstDogDefinition,
        private readonly DogDefinition $secondDogDefinition
    )
    {
    }

    public function __toString(): string
    {
        return $this->ruleText;
    }

    protected function areDogsCorrectlyPlaced(Dog $firstDog, Dog $secondDog): bool
    {
        return $firstDog->getBoardPlace()->isInRightOf($secondDog->getBoardPlace());
    }
    protected function placedDog(Dog $dog): ?Dog
    {
        return $dog->getBoardPlace()->rightBoard()->getDog();
    }

    protected function firstDogDefinition(): DogDefinition
    {
        return $this->firstDogDefinition;
    }

    protected function secondDogDefinition(): DogDefinition
    {
        return $this->secondDogDefinition;
    }
}