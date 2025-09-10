<?php

namespace App\Filament\Resources\TestRunResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Filament\Actions\BulkAction;
use function Laravel\Prompts\form;
use Filament\Forms\Components\Select;

use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class TestCasesRelationManager extends RelationManager
{
    protected static string $relationship = 'testCases';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('id')
                    ->label('#'),
                TextColumn::make('name')
                    ->label('Name'),
                TextColumn::make('title')
                    ->label('Title'),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Action::make('add')
                    ->label('Add')
                    ->icon('heroicon-o-plus')
                    ->schema([
                        Repeater::make('test_cases')
                            ->schema([
                                Select::make('name')
                                    ->required(),
                            ])
                            ->minItems(1)
                            ->maxItems(10)
                            ->label('Test Cases'),
                    ])
                    ->action(function (Table $table) {
                        $table->getRecord()
                            ->testCases()
                            ->attach($table->getRecord()->id);
                    }),
            ])
            ->recordActions([
                Action::make('delete')
                    ->label('Delete')
                    ->icon('heroicon-o-trash')
                    ->action(function (Table $table) {
                        $table->getRecord()
                            ->testCases()
                            ->detach($table->getRecord()->id);
                    }),
            ])
            ->toolbarActions([
                BulkAction::make('delete')
                    ->icon('heroicon-o-trash')
                    ->action(function (Collection $records) {
                        $records->each->delete();
                    }),
            ]);
    }
}
