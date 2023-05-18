<?php

namespace App\Domain\Rule;

use App\Domain\Dog\DogDefinition;
use App\Domain\Evidence;
use App\Domain\Game\Game;

final class DogPlacedInAPlaceWithEvidence implements Rule
{
    public function __construct(
        private readonly string        $ruleText,
        private readonly DogDefinition $dogDefinition,
        private readonly Evidence $evidence
    )
    {
    }

    public function meets(Game $game): bool
    {
        $dogs = $this->dogDefinition->getDogsThatMeets($game->dogs);
        $placedDogs = $dogs->placedDogs();
        foreach ($placedDogs as $dog) {
            if ($dog->getBoardPlace()->hasEvidence($this->evidence)) {
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