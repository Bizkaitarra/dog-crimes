<?php

namespace App\Infrastructure\Rule;

use App\Domain\Rule\Rule;

final class RuleTransformer
{
    public function toArray(Rule $rule): array {
        return [];
    }
}