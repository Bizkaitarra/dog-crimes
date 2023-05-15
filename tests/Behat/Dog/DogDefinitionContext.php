<?php

namespace App\Tests\Behat\Dog;

use App\Domain\Crime;
use App\Domain\Dog\DogDefinition;
use App\Domain\Game\Game;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;

final class DogDefinitionContext implements Context
{
    private DogDefinition $dogDefinition;
    private Game $game;

    /**
     * @Given an undefined dog
     */
    public function anUndefinedDog()
    {
        $this->dogDefinition = new DogDefinition(
            null,
            null,
            null,
            null,
            null,
            null,
            null,
        );
    }

    /**
     * @Given a sample game
     */
    public function aSampleGame()
    {
        $this->game = new Game([], Crime::CAKE);
    }

    /**
     * @Then the dog definition should return :arg1 dogs
     */
    public function theDogDefinitionShouldReturnDogs(int $number)
    {
        $countOfDogsThatMeets = count($this->dogDefinition->getDogsThatMeets($this->game->dogs));
        assert($countOfDogsThatMeets === $number);
    }

    /**
     * @Then /^the following dogs meets definition:$/
     */
    public function theFollowingDogsMeetsDefinition(TableNode $table)
    {
        $dogsThatMeetDefinition = $this->dogDefinition->getDogsThatMeets($this->game->dogs);
        $rows = $table->getRows();
        $countDogsThatMeetDefinition = count($dogsThatMeetDefinition);
        $expectedDogCount = count($rows);
        assert(
            $countDogsThatMeetDefinition === $expectedDogCount,
            sprintf(
                "Expected dog count %s does not match meet count  %s",
                $expectedDogCount,
                $countDogsThatMeetDefinition
            )
        );
        foreach ($rows as $row) {
            assert(
                isset($dogsThatMeetDefinition[$row[0]]),
                sprintf('Dog %s was expected',$row[0])
            );
        }
    }

    /**
     * @Given /^an dog with "([^"]*)"$/
     */
    public function anDogWith($thing)
    {
        $this->dogDefinition = $this->makeThingDefinition($thing);
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
}