<?php

namespace App\Domain\Rule;

use App\Domain\Dog\Dog;
use App\Domain\Dog\DogDefinition;
use App\Domain\Game;

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
        foreach ($this->dogDefinitions as $dogDefinition) {
            $dogsThatMeetsDefinition = $dogDefinition->getDogsThatMeets($game->dogs);

            if (count($dogsThatMeetsDefinition) === 0) {
                throw new IncorrectRuleException($this);
            }

            $notPlacedDogsThatMeetsDefinition = array_filter(
                $dogsThatMeetsDefinition,
                fn (Dog $dog) => !$dog->isPlaced()
            );
            if (count($notPlacedDogsThatMeetsDefinition) === 0) {
                return RuleCompliance::ViolatesTheRule;
            }
        }
        return RuleCompliance::MeetsTheRule;
    }

    public function __toString(): string
    {
        return $this->ruleText;
    }


}