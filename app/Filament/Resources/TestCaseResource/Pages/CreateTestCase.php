<?php

namespace App\Filament\Resources\TestCaseResource\Pages;

use App\Filament\Resources\TestCaseResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTestCase extends CreateRecord
{
    protected static string $resource = TestCaseResource::class;

    protected function afterCreate(): void
    {
        $testCase = $this->record;
        if ($testCase->project_id) {
            $testCase->projectTestCases()->syncWithoutDetaching([$testCase->project_id]);
        }
    }
}
