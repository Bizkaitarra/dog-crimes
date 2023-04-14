<?php

namespace App\Rule;

use App\Dog\Dog;
use App\Dog\DogDefinition;
use App\Game;

class DogNextToDogRule implements Rule
{

    public function __construct(
        private readonly DogDefinition $firstDogDefinition,
        private readonly DogDefinition $secondDogDefinition
    )
    {
    }


    /**
     * @throws \Exception
     */
    public function meets(Game $game): RuleCompliance
    {

        $dogsThatMeetsFirstDefinition = $this->firstDogDefinition->getDogsThatMeets($game->dogs);
        $dogsThatMeetsSecondDefinition = $this->secondDogDefinition->getDogsThatMeets($game->dogs);

        if (empty($dogsThatMeetsFirstDefinition) || empty($dogsThatMeetsSecondDefinition)) {
            throw new \Exception('The rule is not valid for current game, not dogs that meets definitions');
        }

        $placedDogsThatMeetsFirstDogDefinition = array_reduce(
            $dogsThatMeetsFirstDefinition,
            fn (Dog $dog) => $dog->isPlaced()
        );
        $placedDogsThatMeetsSecondDogDefinition = array_reduce(
            $dogsThatMeetsSecondDefinition,
            fn (Dog $dog) => $dog->isPlaced()
        );

        if (empty($placedDogsThatMeetsFirstDogDefinition) || empty($placedDogsThatMeetsSecondDogDefinition)) {
            return RuleCompliance::NotMeetNorViolateTheRule;
        }

        if (count($placedDogsThatMeetsFirstDogDefinition) === 1 && count($placedDogsThatMeetsSecondDogDefinition) === 1) {
            $firstDog = $placedDogsThatMeetsFirstDogDefinition[0];
            $secondDog = $placedDogsThatMeetsFirstDogDefinition[0];
        }

        foreach ($placedDogsThatMeetsFirstDogDefinition as $dogThatMeetsFirstDogDefinition) {

        }

        foreach ($game->board as $boardPlace) {
            //if ($boardPlace->)
        }
        return false;
    }
}