<?php

namespace App\Enums;

enum TestRunStatusEnum: string
{
    case Pending = 'pending';
    case Running = 'running';
    case Completed = 'completed';
}
