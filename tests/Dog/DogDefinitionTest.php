<?php

namespace Dog;

use App\Dog\Dog;
use App\Dog\DogDefinition;
use PHPUnit\Framework\TestCase;

final class DogDefinitionTest extends TestCase
{
    /**
     * @test
     */
    public function notSpecificationShouldReturnThatAnyDogMeets()
    {
        $dogDefinition = new DogDefinition(
            null,
            null,
            null,
            null,
            null,
            null,
            null
        );
        $this->assertCount(6, $dogDefinition->getDogsThatMeets(
            [Dog::makeDaisy(), Dog::makeAce(), Dog::makeCider(), Dog::makePepper(), Dog::makeSuzette(), Dog::makeBeans()]
        ));
    }

    /**
     * @test
     */
    public function daisyShouldMeetByName()
    {
        $dogDefinition = new DogDefinition(
            Dog::DAISY,
            null,
            null,
            null,
            null,
            null,
            null
        );
        $this->assertCount(1, $dogDefinition->getDogsThatMeets(
            [Dog::makeDaisy(), Dog::makeAce(), Dog::makeCider(), Dog::makePepper(), Dog::makeSuzette(), Dog::makeBeans()]
        ));
    }
}