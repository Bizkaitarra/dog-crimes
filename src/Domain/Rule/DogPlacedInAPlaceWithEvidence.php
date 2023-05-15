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
        $dog = $dogs[Dog::CIDER];
        if (!$dog->isPlaced()) {
            return RuleCompliance::NotMeetNorViolateTheRule;
        }
        if ($dog->getBoardPlace()->hasEvidence($this->evidence)) {
            return RuleCompliance::MeetsTheRule;
        }
        return RuleCompliance::ViolatesTheRule;
    }

    public function __toString(): string
    {
        return $this->ruleText;
    }


}