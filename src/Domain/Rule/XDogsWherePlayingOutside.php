<?php

namespace App\Domain\Rule;

use App\Domain\Game\Game;

final class XDogsWherePlayingOutside implements Rule
{
    public function __construct(
        private string $ruleText,
        private int $numberOfDogs
    )
    {
    }

    public function __toString(): string
    {
        return $this->ruleText;
    }

    public function meets(Game $game): RuleCompliance
    {
        if ($game->unPlacedDogs()->count() === $this->numberOfDogs) {
            return RuleCompliance::MeetsTheRule;
        }
        return RuleCompliance::ViolatesTheRule;
    }
}