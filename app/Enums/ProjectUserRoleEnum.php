<?php

namespace App\Enums;

enum ProjectUserRoleEnum: string
{
    case TESTER = 'tester';
    case DEVELOPER = 'developer';
    case MANAGER = 'manager';
}
