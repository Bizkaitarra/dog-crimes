<?php

namespace App\Domain\Game;

use App\Domain\Dog\Dog;
use App\Domain\Rule\Rule;
use App\Domain\Rule\RuleStatus;

final class GameStatus
{
    /**
     * @var RuleStatus[]
     */
    private array $rules = [];
    public function __construct(
        public readonly bool $isSolved,
        public readonly ?Dog $dogThatMadeTheCrime,
    )
    {
    }

    public function addRule(Rule $rule, bool $ruleCompliance): void {
        $this->rules[] = new RuleStatus($rule, $ruleCompliance);
    }

    public function rules(): array
    {
        return $this->rules;
    }
}