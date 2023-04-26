<?php

namespace App\Tests\Domain\Dog;

use App\Domain\Dog\Dog;
use App\Domain\Dog\DogDefinition;
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

    /**
     * @test
     */
    public function daisyShouldNotMeetWithIncorrectName()
    {
        $dogDefinition = new DogDefinition(
            'Incorrect name',
            null,
            null,
            null,
            null,
            null,
            null
        );
        $this->assertCount(0, $dogDefinition->getDogsThatMeets(
            [Dog::makeDaisy()]
        ));
    }
}