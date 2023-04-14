<?php

namespace App\Rule;

enum RuleCompliance
{
    case MeetsTheRule;
    case ViolatesTheRule;
    case NotMeetNorViolateTheRule;

}