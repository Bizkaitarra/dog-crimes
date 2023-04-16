<?php

namespace App\Rule;

use App\Dog\DogDefinition;
use App\Game;

final class DogsWherePlayingOutside implements Rule
{

    /**
     * @param string $ruleText
     * @param DogDefinition[] $dogDefinitions
     */
    public function __construct(
        private string $ruleText,
        private array $dogDefinitions
    )
    {
    }

    /**
     * @throws IncorrectRuleException
     */
    public function meets(Game $game): RuleCompliance
    {
        throw new IncorrectRuleException($this);
    }

    public function __toString(): string
    {
        return $this->ruleText;
    }


}