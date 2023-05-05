<?php

namespace App\Domain\Rule;

use App\Domain\Game\Game;

interface Rule
{
    public function __toString(): string;
    /**
     * @throws IncorrectRuleException
     */
    public function meets(Game $game): RuleCompliance;
}