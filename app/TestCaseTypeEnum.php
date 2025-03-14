<?php

namespace App;

enum TestCaseTypeEnum: string
{
    case FUNCTIONAL = 'functional';
    case REGRESSION = 'regression';
    case SMOKE = 'smoke';
    case MANUAL = 'manual';
    case E2E = 'e2e';
}
