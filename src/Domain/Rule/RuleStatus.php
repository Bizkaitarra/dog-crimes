<?php

namespace App\Domain\Rule;

final class RuleStatus
{
    public function __construct(
        public readonly Rule $rule,
        public readonly RuleCompliance $ruleCompliance
    )
    {
    }
}