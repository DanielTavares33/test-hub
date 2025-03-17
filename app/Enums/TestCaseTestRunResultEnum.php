<?php

namespace App\Enums;

enum TestCaseTestRunResultEnum: string
{
    case PASSED = 'passed';
    case FAILED = 'failed';
    case BLOCKED = 'blocked';
}
