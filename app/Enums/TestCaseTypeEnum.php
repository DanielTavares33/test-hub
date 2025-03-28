<?php

namespace App\Enums;

enum TestCaseTypeEnum: string
{
    case Functional = 'functional';
    case Regression = 'regression';
    case Smoke = 'smoke';
    case Manual = 'manual';
    case E2E = 'e2e';
}
