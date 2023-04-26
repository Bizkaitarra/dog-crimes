<?php

namespace App\Rule;

use App\Dog\Dog;
use App\Dog\DogDefinition;

class DogLeftToDogRule extends TwoDogPlaced
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

    protected function placed(Dog $firstDog, Dog $secondDog): bool
    {
        return $firstDog->getBoardPlace()->isInLeftOf($secondDog->getBoardPlace());
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