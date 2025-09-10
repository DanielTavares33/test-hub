<?php

namespace App\Enums;

enum TestCaseTestRunResultEnum: string
{
    case Passed = 'passed';
    case Failed = 'failed';
    case Blocked = 'blocked';
}
