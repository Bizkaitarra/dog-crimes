<?php

namespace App\Rule;

use App\Game;

interface Rule
{
    public function meets(Game $game): RuleCompliance;
}