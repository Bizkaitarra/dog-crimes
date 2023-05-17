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

    public function meets(Game $game): RuleCompliance
    {
        $dogs = $this->dogDefinition->getDogsThatMeets($game->dogs);
        $placedDogs = $dogs->placedDogs();

        foreach ($placedDogs as $dog) {
            if ($dog->getBoardPlace()->hasEvidence($this->evidence)) {
                return RuleCompliance::MeetsTheRule;
            }
        }
        if (!$this->areThereEnoughtFreePlaces($game)) {
            return RuleCompliance::ViolatesTheRule;
        }
        if ($placedDogs->empty()) {
            return RuleCompliance::NotMeetNorViolateTheRule;
        }
        if ($placedDogs->hasLessDogsThan($dogs)) {
            return RuleCompliance::NotMeetNorViolateTheRule;
        }
        return RuleCompliance::ViolatesTheRule;
    }

    private function areThereEnoughtFreePlaces(Game $game): bool {
        return !$game->freeBoardPlacesWithEvidence($this->evidence)->empty();
    }

    public function __toString(): string
    {
        return $this->ruleText;
    }


}