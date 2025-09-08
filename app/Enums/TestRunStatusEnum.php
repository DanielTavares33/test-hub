<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum TestRunStatusEnum: string implements HasLabel, HasColor
{
    case Pending = 'pending';
    case Running = 'running';
    case Completed = 'completed';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::Running => 'Running',
            self::Completed => 'Completed',
        };
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::Pending => "primary",
            self::Running => "warning",
            self::Completed => "success",
        };
    }
}
