<?php

namespace App\Tests\Domain\Dog;

use App\Domain\Dog\Dog;
use App\Domain\Dog\DogCollection;
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
            DogCollection::makeCompleteCollection()
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
            DogCollection::makeCompleteCollection()
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
            new DogCollection([Dog::makeDaisy()])
        ));
    }
}