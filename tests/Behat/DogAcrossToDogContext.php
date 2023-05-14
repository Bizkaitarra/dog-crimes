<?php

namespace App\Tests\Behat;

use App\Domain\Dog\DogDefinition;
use App\Domain\Game\Game;
use App\Domain\Rule\DogAcrossToDogRule;
use App\Domain\Rule\RuleCompliance;
use Behat\Behat\Context\Context;

final class DogAcrossToDogContext implements Context
{
    private DogAcrossToDogRule $dogAcrossToDogRule;
    private Game $game;
    private RuleCompliance $ruleResult;

    /**
     * @Given the rule is that :firstDogName is across to :secondDogName
     */
    public function aDogWithNameIsAcrossOtherDogWithName(string $firstDogName, string $secondDogName): void
    {
        $this->dogAcrossToDogRule = new DogAcrossToDogRule(
            '',
            new DogDefinition($firstDogName, null, null, null, null, null, null),
            new DogDefinition($secondDogName, null, null, null, null, null, null),
        );
    }

    /**
     * @Given a new game with crime :crime is created
     */
    public function aNewGameIsCreated(string $crime) {
        $this->game = new Game([], $crime);
    }

    /**
     * @When the rule is checked
     */
    public function theRuleIsChecked() {
        $this->ruleResult = $this->dogAcrossToDogRule->meets($this->game);
    }

    /**
     * @Then the result is that the rule has been violated
     */
    public function theRuleHasBeenViolated() {
        return $this->ruleResult === RuleCompliance::ViolatesTheRule;
    }

    /**
     * @Then the result is that the rule has been meet
     */
    public function theRuleHasBeenMeet() {
        return $this->ruleResult === RuleCompliance::MeetsTheRule;
    }

    /**
     * @Then the result is that the rule has been meet not meet nor violated
     */
    public function theRuleHasBeenNotMeetNorViolateTheRule() {
        return $this->ruleResult === RuleCompliance::NotMeetNorViolateTheRule;
    }


}