<?php

namespace App\Domain\Game;

use App\Domain\Dog\Dog;
use App\Domain\Rule\Rule;
use App\Domain\Rule\RuleCompliance;
use App\Domain\Rule\RuleStatus;

final class GameStatus
{
    public array $rules = [];
    public function __construct(
        public readonly bool $isSolved,
        public readonly ?Dog $dogThatMadeTheCrime,
    )
    {
    }

    public function addRule(Rule $rule, RuleCompliance $ruleCompliance) {
        $this->rules[] = new RuleStatus($rule, $ruleCompliance);
    }

}