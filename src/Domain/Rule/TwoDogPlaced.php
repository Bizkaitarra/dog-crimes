<?php

namespace App\Domain\Rule;

use App\Domain\Dog\Dog;
use App\Domain\Dog\DogDefinition;
use App\Domain\Game\Game;

abstract class TwoDogPlaced implements Rule
{
    /**
     * @throws IncorrectRuleException
     */
    public function meets(Game $game): RuleCompliance
    {
        $firstDogDefinition = $this->firstDogDefinition();
        $dogsThatMeetsFirstDefinition = $firstDogDefinition->getDogsThatMeets($game->dogs);
        $secondDogDefinition = $this->secondDogDefinition();
        $dogsThatMeetsSecondDefinition = $secondDogDefinition->getDogsThatMeets($game->dogs);

        if ($dogsThatMeetsFirstDefinition->empty() || $dogsThatMeetsSecondDefinition->empty()) {
            throw new IncorrectRuleException($this);
        }

        $placedDogsThatMeetsFirstDogDefinition = $dogsThatMeetsFirstDefinition->placedDogs();
        $placedDogsThatMeetsSecondDogDefinition = $dogsThatMeetsSecondDefinition->placedDogs();

        /** @var Dog $dogThatMeetsFirstDogDefinition */
        foreach ($placedDogsThatMeetsFirstDogDefinition as $dogThatMeetsFirstDogDefinition) {
            /** @var Dog $placedDogThatMeetsSecondDogDefinition */
            foreach ($placedDogsThatMeetsSecondDogDefinition as $placedDogThatMeetsSecondDogDefinition) {
                if ($this->areDogsCorrectlyPlaced($dogThatMeetsFirstDogDefinition, $placedDogThatMeetsSecondDogDefinition)) {
                    return RuleCompliance::MeetsTheRule;
                }
            }
        }

        // Si todos los perros de 1 están colocados y todos los de 2 también pero no se cumple
        if (
            $dogsThatMeetsFirstDefinition->count() === $placedDogsThatMeetsFirstDogDefinition->count() &&
            $dogsThatMeetsSecondDefinition->count() === $placedDogsThatMeetsSecondDogDefinition->count()
        ) {
            return RuleCompliance::ViolatesTheRule;
        }

        // Si todos los perros de 1 estan colocados y tienen alguien en frente (que no sea de 2)
        if ($dogsThatMeetsFirstDefinition->count() === $placedDogsThatMeetsFirstDogDefinition->count()) {
            foreach ($placedDogsThatMeetsFirstDogDefinition as $dogThatMeetsFirstDogDefinition) {
                if ($this->placedDog($dogThatMeetsFirstDogDefinition) === null) {
                    return RuleCompliance::NotMeetNorViolateTheRule;
                }
            }
            return RuleCompliance::ViolatesTheRule;
        }
        // Si todos los perros de 2 estan colocados y tienen alguien en frente que no sea de 1
        if ($dogsThatMeetsSecondDefinition->count() === $placedDogsThatMeetsSecondDogDefinition->count()) {
            foreach ($placedDogsThatMeetsSecondDogDefinition as $dogThatMeetsSecondDogDefinition) {
                if ($this->placedDog($dogThatMeetsSecondDogDefinition) === null) {
                    return RuleCompliance::NotMeetNorViolateTheRule;
                }
            }
            return RuleCompliance::ViolatesTheRule;
        }


        return RuleCompliance::NotMeetNorViolateTheRule;

    }

    protected abstract function areDogsCorrectlyPlaced(Dog $firstDog, Dog $secondDog): bool;
    protected abstract function placedDog(Dog $dog): ?Dog;

    protected abstract function firstDogDefinition(): DogDefinition;
    protected abstract function secondDogDefinition(): DogDefinition;
}