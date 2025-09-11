<?php

namespace App\Filament\Resources\TestCaseResource\Pages;

use App\Filament\Resources\TestCaseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTestCase extends EditRecord
{
    protected static string $resource = TestCaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $testCase = $this->record;
        if ($testCase->project_id) {
            $testCase->projectTestCases()->syncWithoutDetaching([$testCase->project_id]);
        }
    }
}
