<?php

namespace App\Domain\Rule;

use App\Domain\Crime;
use App\Domain\Dog\DogDefinition;
use App\Domain\Game\Game;

final class DogPlacedInAPlaceWithCrime implements Rule
{
    public function __construct(
        private readonly string        $ruleText,
        private readonly DogDefinition $dogDefinition,
        private readonly Crime $crime
    )
    {
    }

    public function meets(Game $game): bool
    {
        $dogs = $this->dogDefinition->getDogsThatMeets($game->dogs);
        $placedDogs = $dogs->placedDogs();
        foreach ($placedDogs as $dog) {
            if ($dog->getBoardPlace()->getCrime()->equals($this->crime)) {
                return true;
            }
        }
        return false;
    }

    public function __toString(): string
    {
        return $this->ruleText;
    }


}