<?php

namespace App\Enums;

enum ProjectUserRoleEnum: string
{
    case Tester = 'tester';
    case Developer = 'developer';
    case Manager = 'manager';
}
