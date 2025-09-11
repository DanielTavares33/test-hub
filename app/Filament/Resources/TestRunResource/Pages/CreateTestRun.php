<?php

namespace App\Filament\Resources\TestRunResource\Pages;

use App\Filament\Resources\TestRunResource;
use App\Models\ProjectTestRun;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateTestRun extends CreateRecord
{
    protected static string $resource = TestRunResource::class;

    protected function afterCreate(): void
    {
        $testRun = $this->record;
        if ($testRun->project_id) {
            $testRun->projectTestRuns()->syncWithoutDetaching([$testRun->project_id]);
        }
    }
}
