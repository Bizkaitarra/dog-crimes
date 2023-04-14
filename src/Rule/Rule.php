<?php

namespace App\Rule;

use App\Game;

interface Rule
{
    /**
     * @throws IncorrectRuleException
     */
    public function meets(Game $game): RuleCompliance;
}