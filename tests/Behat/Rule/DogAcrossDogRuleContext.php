<?php

declare(strict_types=1);

namespace App\Tests\Behat\Rule;

use App\Domain\Dog\DogDefinition;
use App\Domain\Game\Game;
use App\Domain\Rule\DogAcrossToDogRule;
use App\Domain\Rule\RuleCompliance;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;

final class DogAcrossDogRuleContext implements Context
{
    private DogAcrossToDogRule $dogAcrossToDogRule;
    private Game $game;
    private RuleCompliance $ruleResult;

    private array $acrossPositions = [
        [1, 4],
        [2, 6],
        [3, 5]
    ];

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
     * @Given the rule is that a dog with :firstThing is across a dog with :otherThing
     */
    public function aDogWithThingAcrossADogWithOtherThing(string $firstThing, string $secondThing): void
    {

        $this->dogAcrossToDogRule = new DogAcrossToDogRule(
            '',
            $this->makeThingDefinition($firstThing),
            $this->makeThingDefinition($secondThing)
        );
    }

    /**
     * @Given the rule is that a dog named :dogName is across a dog with :otherThing
     */
    public function aDogNamedIsAcrossADogWithOtherThing(string $dogName, string $secondThing): void
    {

        $this->dogAcrossToDogRule = new DogAcrossToDogRule(
            '',
            new DogDefinition($dogName, null, null, null, null, null, null),
            $this->makeThingDefinition($secondThing)
        );
    }

    private function makeThingDefinition(string $thing): DogDefinition
    {
        return match (strtolower($thing)) {
            'bandana' => new DogDefinition(null, true, null, null, null, null, null),
            'tan_tail' => new DogDefinition(null, null, true, null, null, null, null),
            'perky_ears' => new DogDefinition(null, null, null, true, null, null, null),
            'white_paws' => new DogDefinition(null, null, null, null, true, null, null),
            'collar' => new DogDefinition(null, null, null, null, null, true, null),
            'bow' => new DogDefinition(null, null, null, null, null, null, true),
            default => new DogDefinition(null, null, null, null, null, null, null),
        };
    }

    /**
     * @Given a new game with crime :crime is created
     */
    public function aNewGameIsCreated(string $crime)
    {
        $this->game = new Game([], $crime);
    }

    /**
     * @When the rule is checked
     */
    public function theRuleIsChecked()
    {
        $this->ruleResult = $this->dogAcrossToDogRule->meets($this->game);
    }

    /**
     * @Then the result is that the rule has been violated
     */
    public function theRuleHasBeenViolated()
    {
        assert($this->ruleResult === RuleCompliance::ViolatesTheRule, 'The rule has not been violated');
    }

    /**
     * @Then the result is that the rule has been meet
     */
    public function theRuleHasBeenMeet()
    {
        assert($this->ruleResult === RuleCompliance::MeetsTheRule, 'The rule has not been meet');
    }

    /**
     * @Then the result is that the rule has been meet not meet nor violated
     */
    public function theRuleHasBeenNotMeetNorViolateTheRule()
    {
        assert($this->ruleResult === RuleCompliance::NotMeetNorViolateTheRule, 'The rule has not been nor meet nor violate');
    }

    /**
     * @Given :firstDog is placed across :secondDog
     */
    public function dogPlacedAcross(string $firstDog, string $secondDog)
    {
        $positions = array_shift($this->acrossPositions);
        $dog = $this->game->getDogByName($firstDog);
        $this->game->place($dog, $positions[0]);
        $dog = $this->game->getDogByName($secondDog);
        $this->game->place($dog, $positions[1]);
    }

    /**
     * @Given :dog is placed in :placeNumber
     */
    public function isPlacedIn(string $dogName, int $boardPlaceNumber)
    {
        $dog = $this->game->getDogByName($dogName);
        $this->game->place($dog, $boardPlaceNumber);
    }


}