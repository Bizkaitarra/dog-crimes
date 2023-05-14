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

        if (empty($dogsThatMeetsFirstDefinition) || empty($dogsThatMeetsSecondDefinition)) {
            throw new IncorrectRuleException($this);
        }

        $placedDogsThatMeetsFirstDogDefinition = array_filter(
            $dogsThatMeetsFirstDefinition,
            fn (Dog $dog) => $dog->isPlaced()
        );
        $placedDogsThatMeetsSecondDogDefinition = array_filter(
            $dogsThatMeetsSecondDefinition,
            fn (Dog $dog) => $dog->isPlaced()
        );

        /** @var Dog $dogThatMeetsFirstDogDefinition */
        foreach ($placedDogsThatMeetsFirstDogDefinition as $dogThatMeetsFirstDogDefinition) {
            /** @var Dog $placedDogThatMeetsSecondDogDefinition */
            foreach ($placedDogsThatMeetsSecondDogDefinition as $placedDogThatMeetsSecondDogDefinition) {
                if ($this->placed($dogThatMeetsFirstDogDefinition, $placedDogThatMeetsSecondDogDefinition)) {
                    return RuleCompliance::MeetsTheRule;
                }
            }
        }

        //if (
        //    $this->isADogPlacedInIncorrectPlace($placedDogsThatMeetsFirstDogDefinition, $secondDogDefinition->getDogsThatDontMeet($game->dogs)) ||
        //    $this->isADogPlacedInIncorrectPlace($placedDogsThatMeetsSecondDogDefinition, $firstDogDefinition->getDogsThatDontMeet($game->dogs))
        //
        //) {
        //    return RuleCompliance::ViolatesTheRule;
        //}

        if (
            count($dogsThatMeetsFirstDefinition) > count($placedDogsThatMeetsFirstDogDefinition) ||
            count($dogsThatMeetsSecondDefinition) > count($placedDogsThatMeetsSecondDogDefinition)
        ) {
            return RuleCompliance::NotMeetNorViolateTheRule;
        }

        return RuleCompliance::ViolatesTheRule;
    }

    private function isADogPlacedInIncorrectPlace(array $placedDogsThatMeetFirstDefinition, array $dogsThatDontMeetsTheOtherDefinition): bool {

        foreach ($placedDogsThatMeetFirstDefinition as $placedDog) {
            $dogsPlacedInIncorrectPosition = array_filter($dogsThatDontMeetsTheOtherDefinition, fn($dog) =>
                $dog->getName() !== $placedDog->getName() &&
                ($this->placed($placedDog, $dog))
            );
            if (count($dogsPlacedInIncorrectPosition) === 0) {
                return false;
            }
        }
        return true;
    }

    protected abstract function placed(Dog $firstDog, Dog $secondDog): bool;

    protected abstract function firstDogDefinition(): DogDefinition;
    protected abstract function secondDogDefinition(): DogDefinition;
}