<?php

namespace App\Domain\Rule;

use App\Domain\Dog\DogDefinition;
use App\Domain\Game\Game;

final class DogsWherePlayingOutside implements Rule
{

    /**
     * @param string $ruleText
     * @param DogDefinition[] $dogDefinitions
     */
    public function __construct(
        private readonly string $ruleText,
        private readonly array  $dogDefinitions
    )
    {
    }

    /**
     * @throws IncorrectRuleException
     */
    public function meets(Game $game): bool
    {
        foreach ($this->dogDefinitions as $dogDefinition) {
            $dogsThatMeetsDefinition = $dogDefinition->getDogsThatMeets($game->dogs);

            if ($dogsThatMeetsDefinition->empty()) {
                throw new IncorrectRuleException($this);
            }

            $notPlacedDogsThatMeetsDefinition = $dogsThatMeetsDefinition->unPlacedDogs();
            if ($notPlacedDogsThatMeetsDefinition->empty()) {
                return false;
            }
        }
        return true;
    }

    public function __toString(): string
    {
        return $this->ruleText;
    }

}