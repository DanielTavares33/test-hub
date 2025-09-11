<?php

namespace App\Filament\Resources\TestRunResource\Pages;

use App\Filament\Resources\TestRunResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTestRun extends EditRecord
{
    protected static string $resource = TestRunResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $testRun = $this->record;
        if ($testRun->project_id) {
            $testRun->projectTestRuns()->sync([$testRun->project_id]);
        }
    }
}
