<?php

namespace App\Tests\Rule;

use App\Crime;
use App\Dog\Dog;
use App\Dog\DogDefinition;
use App\Game;
use App\Rule\DogNextToDogRule;
use App\Rule\IncorrectRuleException;
use App\Rule\RuleCompliance;
use App\Tests\Dog\DogDefinitionMother;
use PHPUnit\Framework\TestCase;

final class DogNetToDogRuleTest extends TestCase
{
    /**
     * @test
     * @testdox Sending in constructor a first definition that could not be meet should return IncorrectRuleException
     */
    public function invalidFirstDogDefinition() {
        $ruleText = 'A not existing dog is next to cider';
        $firstDogDefinition = DogDefinitionMother::notMeeteableDogDefinition();
        $secondDogDefinition = DogDefinitionMother::specificDogDefinition(Dog::makeCider());
        $rule = new DogNextToDogRule(
            $ruleText,
            $firstDogDefinition,
            $secondDogDefinition
        );

        $game = new Game([], Crime::CAKE);

        $this->expectExceptionMessage(sprintf(
            'The rule %s is not valid for current game, not dogs that meets definitions',
            $ruleText
        ));
        $this->expectException(IncorrectRuleException::class);
        $rule->meets($game);

        $reverseRule = new DogNextToDogRule(
            $ruleText,
            $firstDogDefinition,
            $secondDogDefinition
        );
        $this->expectExceptionMessage(sprintf(
            'The rule %s is not valid for current game, not dogs that meets definitions',
            $ruleText
        ));
        $this->expectException(IncorrectRuleException::class);
        $reverseRule->meets($game);
    }

    /**
     * @test
     * @testdox When there are dogs meeting both definitions but no one of them is placed should return not meet nor violate the rule
     */
    public function notPlacedDogsMeetTheDefinition() {
        $firstDogDefinition = DogDefinitionMother::specificDogDefinition(Dog::makeCider());
        $secondDogDefinition = DogDefinitionMother::specificDogDefinition(Dog::makeDaisy());
        $game = new Game([], Crime::CAKE);

        $rule = new DogNextToDogRule(
            'Cider is next to Daisy',
            $firstDogDefinition,
            $secondDogDefinition
        );

        $this->assertEquals(RuleCompliance::NotMeetNorViolateTheRule, $rule->meets($game));

        $reverseRule = new DogNextToDogRule(
            'Cider is next to Daisy',
            $secondDogDefinition,
            $firstDogDefinition
        );
        $this->assertEquals(RuleCompliance::NotMeetNorViolateTheRule, $reverseRule->meets($game));
    }

    /**
     * @test
     * @testdox Cider/Daisy is next to Beans/Ace when Cider and beans are placed and not next to
     */
    public function twoPlacedDogsAreNotNextButOthersCouldMeetTheRule() {
        $firstDogDefinition = DogDefinitionMother::definitionForTwoDog(Dog::makeCider(), Dog::makeDaisy());
        $secondDogDefinition = DogDefinitionMother::definitionForTwoDog(Dog::makeBeans(), Dog::makeAce());

        $game = new Game([], Crime::CAKE);
        $game->place(Dog::makeCider(), 1);
        $game->place(Dog::makeBeans(), 3);

        $rule = new DogNextToDogRule(
            'Cider is next to Daisy',
            $firstDogDefinition,
            $secondDogDefinition,
        );

        $this->assertEquals(RuleCompliance::NotMeetNorViolateTheRule, $rule->meets($game));

        $reverseRule = new DogNextToDogRule(
            'Daisy is next to Cider',
            $firstDogDefinition,
            $secondDogDefinition,
        );

        $this->assertEquals(RuleCompliance::NotMeetNorViolateTheRule, $reverseRule->meets($game));
    }

    /**
     * @test
     * @testdox When there is only a dog that meet each definition and the dogs are placed not next to should return that violates the rule
     */
    public function dogsThatAreNotNextTo() {
        $firstDogDefinition = DogDefinitionMother::specificDogDefinition(Dog::makeCider());
        $secondDogDefinition = DogDefinitionMother::specificDogDefinition(Dog::makeDaisy());

        $game = new Game([], Crime::CAKE);
        $game->place(Dog::makeCider(), 1);
        $game->place(Dog::makeDaisy(), 3);

        $rule = new DogNextToDogRule(
            'Cider is next to Daisy',
            $firstDogDefinition,
            $secondDogDefinition
        );

        $this->assertEquals(RuleCompliance::ViolatesTheRule, $rule->meets($game));

        $reverseRule = new DogNextToDogRule(
            'Daisy is next to Cider',
            $secondDogDefinition,
            $firstDogDefinition
        );

        $this->assertEquals(RuleCompliance::ViolatesTheRule, $reverseRule->meets($game));
    }

    /**
     * @test
     */
    public function whenThereArePlacedDogsThatMeetDefinitionsAndTheUniqueMeetingPairOfThemIsNextShouldReturnMeetsTheRule() {
        $firstDogDefinition = DogDefinitionMother::specificDogDefinition(Dog::makeCider());
        $secondDogDefinition = DogDefinitionMother::specificDogDefinition(Dog::makeDaisy());

        $game = new Game([], Crime::CAKE);

        $game->place(Dog::makeCider(), 1);
        $game->place(Dog::makeDaisy(), 2);

        $rule = new DogNextToDogRule(
            'Cider is next to Daisy',
            $firstDogDefinition,
            $secondDogDefinition
        );

        $this->assertEquals(RuleCompliance::MeetsTheRule, $rule->meets($game));

        $reverseRule = new DogNextToDogRule(
            'Daisy is next to Cider',
            $secondDogDefinition,
            $firstDogDefinition
        );

        $this->assertEquals(RuleCompliance::MeetsTheRule, $reverseRule->meets($game));
    }

    /**
     * @test
     */
    public function whenThereArePlacedDogsThatMeetDefinitionsAndOnlyAPairOfThemIsNextShouldReturnMeetsTheRule() {

        $game = new Game([], Crime::CAKE);

        $game->place(Dog::makeCider(), 1);
        $game->place(Dog::makeDaisy(), 2);
        $game->place(Dog::makePepper(), 4);

        $firstDogDefinition = DogDefinitionMother::definitionForTwoDog(
            $game->getDogByName(Dog::CIDER),
            $game->getDogByName(Dog::PEPPER)
        );
        $secondDogDefinition = DogDefinitionMother::specificDogDefinition(Dog::makeDaisy());

        $rule = new DogNextToDogRule(
            'Cider is next to Daisy',
            $firstDogDefinition,
            $secondDogDefinition
        );

        $this->assertEquals(RuleCompliance::MeetsTheRule, $rule->meets($game));

        $reverseRule = new DogNextToDogRule(
            'Daisy is next to Cider',
            $secondDogDefinition,
            $firstDogDefinition
        );

        $this->assertEquals(RuleCompliance::MeetsTheRule, $reverseRule->meets($game));
    }

    /**
     * @test
     */
    public function whenThereArePlacedDogsThatMeetDefinitionsAndMoreThanOnePairOfThemIsNextShouldReturnMeetsTheRule() {
        $game = new Game([], Crime::CAKE);

        $firstDogDefinition = DogDefinitionMother::definitionForTwoDog(
            $game->getDogByName(Dog::CIDER),
            $game->getDogByName(Dog::PEPPER)
        );
        $secondDogDefinition = DogDefinitionMother::definitionForTwoDog(
            $game->getDogByName(Dog::DAISY),
            $game->getDogByName(Dog::ACE)
        );

        $game->place(Dog::makeCider(), 1);
        $game->place(Dog::makeDaisy(), 2);

        $game->place(Dog::makePepper(), 3);
        $game->place(Dog::makeAce(), 4);

        $rule = new DogNextToDogRule(
            'Cider is next to Daisy',
            $firstDogDefinition,
            $secondDogDefinition
        );

        $this->assertEquals(RuleCompliance::MeetsTheRule, $rule->meets($game));

        $reverseRule = new DogNextToDogRule(
            'Daisy is next to Cider',
            $secondDogDefinition,
            $firstDogDefinition
        );

        $this->assertEquals(RuleCompliance::MeetsTheRule, $reverseRule->meets($game));
    }


    /**
     * @dataProvider dataProvider
     */
    public function test(
        string $ruleText,
        array $firstDogDefinitionDogs,
        array $secondDogDefinitionDogs,
        array $placedDogs,
        RuleCompliance $expectedResult,
    ) {
        $game = new Game([], Crime::CAKE);

        $firstDogDefinition = DogDefinitionMother::definitionForMultipleDogs($firstDogDefinitionDogs, $game);
        $secondDogDefinition = DogDefinitionMother::definitionForMultipleDogs($secondDogDefinitionDogs, $game);

        foreach ($placedDogs as $dog => $place) {
            $game->place($game->getDogByName($dog), $place);
        }

        $rule = new DogNextToDogRule(
            $ruleText,
            $firstDogDefinition,
            $secondDogDefinition
        );

        $reverseRule = new DogNextToDogRule(
            $ruleText,
            $firstDogDefinition,
            $secondDogDefinition
        );
        $this->assertEquals($expectedResult, $rule->meets($game));
        $this->assertEquals($expectedResult, $reverseRule->meets($game));
    }

    public function dataProvider()
    {
        return
            [
                [
                    'Cider or Ace is next to daisy. No placed dogs',
                    [Dog::CIDER, Dog::ACE],
                    [Dog::DAISY, Dog::ACE],
                    [],
                    RuleCompliance::NotMeetNorViolateTheRule
                ],
                [
                    'Cider or Ace is next to daisy. No placed dogs in some of the conditions',
                    [Dog::CIDER, Dog::ACE],
                    [Dog::DAISY, Dog::ACE],
                    [Dog::DAISY => 1],
                    RuleCompliance::NotMeetNorViolateTheRule
                ],
                [
                    'Cider or Ace is next to daisy. Only placed the one is in both',
                    [Dog::CIDER, Dog::ACE],
                    [Dog::DAISY, Dog::ACE],
                    [Dog::ACE => 1],
                    RuleCompliance::NotMeetNorViolateTheRule
                ],
                [
                    'Cider or Ace is next to daisy. Placed dogs does not meet but steal other could meet it',
                    [Dog::CIDER, Dog::ACE],
                    [Dog::DAISY, Dog::ACE],
                    [Dog::DAISY => 1, Dog::CIDER => 3],
                    RuleCompliance::NotMeetNorViolateTheRule
                ],
                [
                    'Cider or Ace is next to daisy. Meets',
                    [Dog::CIDER, Dog::ACE],
                    [Dog::DAISY, Dog::ACE],
                    [Dog::DAISY => 1, Dog::CIDER => 2, Dog::ACE => 5],
                    RuleCompliance::MeetsTheRule
                ],
                [
                    'Cider or Ace is next to daisy. Violates',
                    [Dog::CIDER, Dog::ACE],
                    [Dog::DAISY, Dog::ACE],
                    [Dog::DAISY => 1, Dog::CIDER => 3, Dog::ACE => 5],
                    RuleCompliance::ViolatesTheRule
                ],
                [
                    'Cider or Ace is next to daisy. NotMeetNorViolateTheRule',
                    [Dog::CIDER, Dog::ACE],
                    [Dog::DAISY, Dog::ACE],
                    [Dog::DAISY => 1,  Dog::ACE => 5],
                    RuleCompliance::NotMeetNorViolateTheRule
                ],
                [
                    'Cider or Ace is next to daisy. NotMeetNorViolateTheRule 2',
                    [Dog::CIDER, Dog::ACE],
                    [Dog::DAISY, Dog::ACE],
                    [Dog::CIDER => 1,  Dog::ACE => 5],
                    RuleCompliance::NotMeetNorViolateTheRule
                ],
                [
                    'Cider or Ace is next to daisy. NotMeetNorViolateTheRule 3',
                    [Dog::CIDER, Dog::ACE],
                    [Dog::DAISY],
                    [Dog::CIDER => 1,  Dog::ACE => 2],
                    RuleCompliance::NotMeetNorViolateTheRule
                ]
            ];
    }

}