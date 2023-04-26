<?php

namespace App\Domain\Rule;

enum RuleCompliance
{
    case MeetsTheRule;
    case ViolatesTheRule;
    case NotMeetNorViolateTheRule;

}