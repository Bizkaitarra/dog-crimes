<?php

namespace App\Domain\Rule;

use App\Domain\Dog\Dog;
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

    public function meets(Game $game): RuleCompliance
    {
        $dogs = $this->dogDefinition->getDogsThatMeets($game->dogs);
        $placedDogs = array_filter($dogs, fn($dog) => $dog->isPlaced());
        if (count($placedDogs) === 0) {
            return RuleCompliance::NotMeetNorViolateTheRule;
        }
        foreach ($placedDogs as $dog) {
            if ($dog->getBoardPlace()->hasEvidence($this->evidence)) {
                return RuleCompliance::MeetsTheRule;
            }
        }
        if (count($placedDogs) < count($dogs)) {
            return RuleCompliance::NotMeetNorViolateTheRule;
        }
        return RuleCompliance::ViolatesTheRule;
    }

    public function __toString(): string
    {
        return $this->ruleText;
    }


}