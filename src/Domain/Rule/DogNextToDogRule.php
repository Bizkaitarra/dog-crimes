<?php

namespace App\Domain\Rule;

use App\Domain\Dog\Dog;
use App\Domain\Dog\DogDefinition;

class DogNextToDogRule extends TwoDogPlaced
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
        return $firstDog->getBoardPlace()->isNextTo($secondDog->getBoardPlace());
    }

    protected function placedDog(Dog $dog): ?Dog
    {
        //TODO: This rule could not be in the same place as others TwoDogPlaced because two places are included
        return null;
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