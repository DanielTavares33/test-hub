<?php

namespace App\Enums;

enum TestCaseTypeEnum: string
{
    case Functional = 'functional';
    case Regression = 'regression';
    case Smoke = 'smoke';
    case Manuel = 'manual';
    case E2E = 'e2e';
}
