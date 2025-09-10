<?php

namespace App\Filament\Resources\TestRunResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use function Laravel\Prompts\form;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class TestCasesRelationManager extends RelationManager
{
    protected static string $relationship = 'testCases';

    public function form(Form $form): Form
    {
        return $form
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
                    ->form([
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
            ->actions([
                Action::make('delete')
                    ->label('Delete')
                    ->icon('heroicon-o-trash')
                    ->action(function (Table $table) {
                        $table->getRecord()
                            ->testCases()
                            ->detach($table->getRecord()->id);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
