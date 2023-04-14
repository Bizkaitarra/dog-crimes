<?php

namespace Rule;

use App\BoardPlace;
use App\Crime;
use App\Dog\Dog;
use App\Dog\DogDefinition;
use App\Game;
use App\Rule\DogNextToDogRule;
use App\Rule\IncorrectRuleException;
use App\Rule\RuleCompliance;
use PHPUnit\Framework\TestCase;

final class DogNetToDogRuleTest extends TestCase
{
    /**
     * @test
     */
    public function ruleThatCantBeNeverMeetShouldReturnException() {
        $rule = new DogNextToDogRule(
            new DogDefinition(
                'NotExistingDog', null, null, null,null, null, null
            ),
            new DogDefinition(
                null, null, null, null,null, null, null
            )
        );
        $game = new Game([$rule], Crime::CAKE);

        $this->expectException(IncorrectRuleException::class);
        $rule->meets($game);
    }

    /**
     * @test
     */
    public function whenExistingDogsThatMeetDefinitionsButNotPlacedShouldReturnNotMeetNorViolateTheRule() {
        $rule = new DogNextToDogRule(
            new DogDefinition(
                null, null, null, null,null, null, null
            ),
            new DogDefinition(
                null, null, null, null,null, null, null
            )
        );
        $game = new Game([$rule], Crime::CAKE);

        $this->assertEquals(RuleCompliance::NotMeetNorViolateTheRule, $rule->meets($game));
    }

    /**
     * @test
     */
    public function whenThereArePlacedDogsThatMeetDefinitionsThatAreNotNextToShouldReturnViolatesTheRule() {
        $rule = new DogNextToDogRule(
            new DogDefinition(
                null, null, null, null,null, null, null
            ),
            new DogDefinition(
                null, null, null, null,null, null, null
            )
        );
        $game = new Game([$rule], Crime::CAKE);

        $game->place(Dog::makeCider(), 1);
        $game->place(Dog::makeDaisy(), 3);
        $this->assertEquals(RuleCompliance::ViolatesTheRule, $rule->meets($game));
    }

}