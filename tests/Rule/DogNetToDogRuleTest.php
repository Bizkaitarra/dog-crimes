<?php

namespace App\Tests\Rule;

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
        $ruleText = 'A dog named NotExistingDog is next to and other dog';
        $rule = new DogNextToDogRule(
            $ruleText,
            new DogDefinition(
                'NotExistingDog', null, null, null,null, null, null
            ),
            new DogDefinition(
                null, null, null, null,null, null, null
            )
        );
        $game = new Game([$rule], Crime::CAKE);

        $this->expectExceptionMessage(sprintf(
            'The rule %s is not valid for current game, not dogs that meets definitions',
            $ruleText
        ));
        $this->expectException(IncorrectRuleException::class);
        $rule->meets($game);
    }
    /**
     * @test
     */
    public function ruleThatCantBeNeverMeetNotMeetsTheSecondDefinitionShouldReturnException() {
        $ruleText = 'A dog named NotExistingDog is next to and other dog';
        $rule = new DogNextToDogRule(
            $ruleText,
            new DogDefinition(
               null , null, null, null,null, null, null
            ),
            new DogDefinition(
                'NotExistingDog', null, null, null,null, null, null
            )
        );

        $game = new Game([$rule], Crime::CAKE);

        $this->expectExceptionMessage(sprintf(
            'The rule %s is not valid for current game, not dogs that meets definitions',
            $ruleText
        ));
        $this->expectException(IncorrectRuleException::class);
        $rule->meets($game);
    }

    /**
     * @test
     */
    public function whenExistingDogsThatMeetDefinitionsButNotPlacedShouldReturnNotMeetNorViolateTheRule() {
        $rule = new DogNextToDogRule(
            'A dog is next other dog',
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
            'A dog is next other dog',
            new DogDefinition(
                Dog::CIDER, null, null, null,null, null, null
            ),
            new DogDefinition(
                Dog::DAISY, null, null, null,null, null, null
            )
        );
        $game = new Game([$rule], Crime::CAKE);

        $game->place(Dog::makeCider(), 1);
        $game->place(Dog::makeDaisy(), 3);
        $this->assertEquals(RuleCompliance::ViolatesTheRule, $rule->meets($game));
    }

    /**
     * @test
     */
    public function whenThereArePlacedDogsThatMeetDefinitionsAndTheUniqueMeetingPairOfThemIsNextShouldReturnMeetsTheRule() {
        $rule = new DogNextToDogRule(
            'A dog is next other dog',
            new DogDefinition(
                null, null, null, null,null, null, null
            ),
            new DogDefinition(
                null, null, null, null,null, null, null
            )
        );
        $game = new Game([$rule], Crime::CAKE);

        $game->place(Dog::makeCider(), 1);
        $game->place(Dog::makeDaisy(), 2);
        $this->assertEquals(RuleCompliance::MeetsTheRule, $rule->meets($game));
    }

    /**
     * @test
     */
    public function whenThereArePlacedDogsThatMeetDefinitionsAndOnlyAPairOfThemIsNextShouldReturnMeetsTheRule() {
        $rule = new DogNextToDogRule(
            'A dog is next other dog',
            new DogDefinition(
                null, null, null, null,null, null, null
            ),
            new DogDefinition(
                null, null, null, null,null, null, null
            )
        );
        $game = new Game([$rule], Crime::CAKE);

        $game->place(Dog::makeCider(), 1);
        $game->place(Dog::makeDaisy(), 2);

        $game->place(Dog::makePepper(), 4);

        $this->assertEquals(RuleCompliance::MeetsTheRule, $rule->meets($game));
    }

    /**
     * @test
     */
    public function whenThereArePlacedDogsThatMeetDefinitionsAndMoreThanOnePairOfThemIsNextShouldReturnMeetsTheRule() {
        $rule = new DogNextToDogRule(
            'A dog is next other dog',
            new DogDefinition(
                null, null, null, null,null, null, null
            ),
            new DogDefinition(
                null, null, null, null,null, null, null
            )
        );
        $game = new Game([$rule], Crime::CAKE);

        $game->place(Dog::makeCider(), 1);
        $game->place(Dog::makeDaisy(), 2);

        $game->place(Dog::makePepper(), 3);
        $game->place(Dog::makeAce(), 4);

        $this->assertEquals(RuleCompliance::MeetsTheRule, $rule->meets($game));
    }

}