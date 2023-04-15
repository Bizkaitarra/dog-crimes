<?php

namespace App\Rule;

final class IncorrectRuleException extends \Exception
{
    public function __construct(Rule $rule)
    {
        parent::__construct(
            sprintf(
                'The rule %s is not valid for current game, not dogs that meets definitions',
                $rule->__toString()
            )
        );
    }

}