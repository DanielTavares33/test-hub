<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\TestCase;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\TestCaseResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TestCaseResource\RelationManagers;

class TestCaseResource extends Resource
{
    protected static ?string $model = TestCase::class;

    protected static ?string $navigationIcon = 'carbon-document';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('#')
                    ->sortable(),
                TextColumn::make('type')
                    ->badge()
                    ->color('gray')
                    ->formatStateUsing(function ($state) {
                        if ($state->value === 'e2e') {
                            return 'E2E';
                        };

                        return ucfirst($state->value);
                    })
                    ->searchable()
                    ->sortable(),
                TextColumn::make('project.name')
                    ->label('Project')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn($state): string => match ($state->value) {
                        'passed' => 'success',
                        'failed' => 'danger',
                        'active' => 'info',
                        'draft' => 'gray',
                        default => 'secondary',
                    })
                    ->formatStateUsing(fn($state) => ucfirst($state->value))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('priority')
                    ->badge()
                    ->color(fn($state): string => match ($state->value) {
                        'high' => 'danger',
                        'medium' => 'warning',
                        'low' => 'success',
                        default => 'secondary',
                    })
                    ->formatStateUsing(fn($state) => ucfirst($state->value))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->hiddenLabel()
                    ->tooltip('Edit')
                    ->color(Color::Amber),
                Tables\Actions\DeleteAction::make()
                    ->hiddenLabel()
                    ->tooltip('Delete'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTestCases::route('/'),
            'create' => Pages\CreateTestCase::route('/create'),
            'edit' => Pages\EditTestCase::route('/{record}/edit'),
        ];
    }
}
