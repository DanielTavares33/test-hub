<?php

namespace App\Enums;

enum TestCaseStatusEnum: string
{
    case Draft = 'draft';
    case Active = 'active';
    case Passed = 'passed';
    case Failed = 'failed';
}
