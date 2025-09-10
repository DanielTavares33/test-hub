<?php

namespace App\Filament\Resources\TestRunResource\Pages;

use App\Filament\Resources\TestRunResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTestRuns extends ListRecords
{
    protected static string $resource = TestRunResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
