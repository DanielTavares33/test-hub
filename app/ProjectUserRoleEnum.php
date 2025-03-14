<?php

namespace App;

enum ProjectUserRoleEnum: string
{
    case TESTER = 'tester';
    case DEVELOPER = 'developer';
    case MANAGER = 'manager';
}
