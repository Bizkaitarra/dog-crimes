<?php

namespace App\Tests\Domain\Rule;

use App\Domain\Crime;
use App\Domain\Dog\Dog;
use App\Domain\Dog\DogDefinition;
use App\Domain\Game\Game;
use App\Domain\Rule\DogsWherePlayingOutside;
use App\Domain\Rule\IncorrectRuleException;
use App\Domain\Rule\RuleCompliance;
use PHPUnit\Framework\TestCase;

final class DogsWherePlayingOutsideTest extends TestCase
{
    public function ruleThatCantBeNeverMeetShouldReturnException(): void
    {
        $ruleText = 'A dog named NotExistingDog was playing outside';
        $rule = new DogsWherePlayingOutside(
            $ruleText,
            [
                new DogDefinition(
                    'NotExistingDog', null, null, null, null, null, null
                )
            ]
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
    public function whenExistingADogThatMeetsAndIsPlacedShouldReturnViolatesTheRule() {
        $ruleText = 'A dog named Cider was playing outside';
        $rule = new DogsWherePlayingOutside(
            $ruleText,
            [
                new DogDefinition(
                    'Cider', null, null, null, null, null, null
                )
            ]
        );
        $game = new Game([$rule], Crime::CAKE);

        $game->place(Dog::makeCider(), 1);
        $this->assertEquals(RuleCompliance::ViolatesTheRule, $rule->meets($game));
    }


    /**
     * @test
     */
    public function whenExistingSomeDogsThatMeetsAndAreAllPlacedShouldReturnViolatesTheRule() {
        $ruleText = 'A dog with bandana was playing outside';
        $rule = new DogsWherePlayingOutside(
            $ruleText,
            [
                new DogDefinition(
                    null, true, null, null, null, null, null
                )
            ]
        );
        $game = new Game([$rule], Crime::CAKE);

        $game->place(Dog::makeAce(), 1);
        $game->place(Dog::makeDaisy(), 2);
        $this->assertEquals(RuleCompliance::ViolatesTheRule, $rule->meets($game));
    }


    /**
     * @test
     */
    public function whenExistingSomeDogsThatMeetsAndOneIsNotPlacedShouldReturnViolatesTheRule() {
        $ruleText = 'A dog with bandana was playing outside';
        $rule = new DogsWherePlayingOutside(
            $ruleText,
            [
                new DogDefinition(
                    null, true, null, null, null, null, null
                )
            ]
        );
        $game = new Game([$rule], Crime::CAKE);

        $game->place(Dog::makeAce(), 1);
        $this->assertEquals(RuleCompliance::MeetsTheRule, $rule->meets($game));
    }


    /**
     * @test
     */
    public function twoDogsPlayingOutSideButAllDogsThatMeetDefinitionArePlaced() {
        $ruleText = 'A dog with bandana and a dog with tan tail where playing outside';
        $rule = new DogsWherePlayingOutside(
            $ruleText,
            [
                new DogDefinition(
                    null, true, null, null, null, null, null
                ),
                new DogDefinition(
                    null, false, true, null, null, null, null
                )
            ]
        );
        $game = new Game([$rule], Crime::CAKE);

        $game->place(Dog::makeAce(), 1);
        $game->place(Dog::makeDaisy(), 2);
        $game->place(Dog::makeBeans(), 3);


        $this->assertEquals(RuleCompliance::ViolatesTheRule, $rule->meets($game));
    }


    /**
     * @test
     */
    public function twoDogsPlayingOutSideButNotAllDogsThatMeetDefinitionArePlaced() {
        $ruleText = 'A dog with bandana and a dog with tan tail where playing outside';
        $rule = new DogsWherePlayingOutside(
            $ruleText,
            [
                new DogDefinition(
                    null, true, null, null, null, null, null
                ),
                new DogDefinition(
                    null, null, true, null, null, null, null
                )
            ]
        );
        $game = new Game([$rule], Crime::CAKE);

        $game->place(Dog::makeAce(), 1);
        $game->place(Dog::makeBeans(), 3);


        $this->assertEquals(RuleCompliance::MeetsTheRule, $rule->meets($game));
    }
}