<?php

namespace App\Tests\Rule;

use App\Crime;
use App\Dog\DogDefinition;
use App\Game;
use App\Rule\DogsWherePlayingOutside;
use App\Rule\IncorrectRuleException;
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
}