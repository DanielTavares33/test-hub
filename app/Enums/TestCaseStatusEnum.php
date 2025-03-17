<?php

namespace App\Enums;

enum TestCaseStatusEnum: string
{
    case DRAFT = 'draft';
    case ACTIVE = 'active';
    case PASSED = 'passed';
    case FAILED = 'failed';
}
