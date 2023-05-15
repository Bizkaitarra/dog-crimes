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
        return RuleCompliance::MeetsTheRule;
    }

    public function __toString(): string
    {
        return $this->ruleText;
    }


}