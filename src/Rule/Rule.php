<?php

namespace App\Rule;

use App\Game;

interface Rule
{
    public function __toString(): string;
    /**
     * @throws IncorrectRuleException
     */
    public function meets(Game $game): RuleCompliance;
}