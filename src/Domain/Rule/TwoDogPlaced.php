<?php

namespace App\Domain\Rule;

use App\Domain\Dog\Dog;
use App\Domain\Dog\DogDefinition;
use App\Domain\Game\Game;

abstract class TwoDogPlaced implements Rule
{
    /**
     * @throws IncorrectRuleException
     */
    public function meets(Game $game): bool
    {
        $firstDogDefinition = $this->firstDogDefinition();
        $dogsThatMeetsFirstDefinition = $firstDogDefinition->getDogsThatMeets($game->dogs);
        $secondDogDefinition = $this->secondDogDefinition();
        $dogsThatMeetsSecondDefinition = $secondDogDefinition->getDogsThatMeets($game->dogs);

        if ($dogsThatMeetsFirstDefinition->empty() || $dogsThatMeetsSecondDefinition->empty()) {
            throw new IncorrectRuleException($this);
        }

        $placedDogsThatMeetsFirstDogDefinition = $dogsThatMeetsFirstDefinition->placedDogs();
        $placedDogsThatMeetsSecondDogDefinition = $dogsThatMeetsSecondDefinition->placedDogs();

        /** @var Dog $dogThatMeetsFirstDogDefinition */
        foreach ($placedDogsThatMeetsFirstDogDefinition as $dogThatMeetsFirstDogDefinition) {
            /** @var Dog $placedDogThatMeetsSecondDogDefinition */
            foreach ($placedDogsThatMeetsSecondDogDefinition as $placedDogThatMeetsSecondDogDefinition) {
                if ($this->areDogsCorrectlyPlaced($dogThatMeetsFirstDogDefinition, $placedDogThatMeetsSecondDogDefinition)) {
                    return true;
                }
            }
        }
        return false;

    }

    protected abstract function areDogsCorrectlyPlaced(Dog $firstDog, Dog $secondDog): bool;
    protected abstract function firstDogDefinition(): DogDefinition;
    protected abstract function secondDogDefinition(): DogDefinition;
}