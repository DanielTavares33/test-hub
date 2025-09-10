<?php

namespace App\Enums;

enum BugSeverityEnum: string
{
    case Low = 'low';
    case Medium = 'medium';
    case High = 'high';
    case Critical = 'critical';
}
