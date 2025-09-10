<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Filament\Schemas\Schema;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Schemas\Components\Flex;

class ProjectResource extends Resource
{
    protected static string|BackedEnum|null $navigationIcon = 'carbon-industry';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Flex::make([
                    Section::make()
                    ->schema([
                        TextInput::make('name')
                            ->label('Name')
                            ->required()
                            ->minLength(3)
                            ->maxLength(255)
                            ->autofocus(),
                        Toggle::make('status')
                            ->label('Is Active')
                            ->default(false),
                        Textarea::make('description')
                            ->label('Description')
                            ->nullable()
                            ->rows(3),
                    ]),
                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('#'),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Name'),
                TextColumn::make('description')
                    ->label('Description')
                    ->limit(20)
                    ->tooltip(fn($state) => $state),
                TextColumn::make('users')
                    ->label('Users')
                    ->badge()
                    ->sortable()
                    ->state(function (Project $project) {
                        return $project->users()->count();
                    })
                    ->alignCenter(),
                TextColumn::make('projectTestCases')
                    ->label('Test Cases')
                    ->badge()
                    ->sortable()
                    ->state(function (Project $project) {
                        return $project->projectTestCases()->count();
                    })
                    ->alignCenter(),
                TextColumn::make('projectTestRuns')
                    ->label('Test Runs')
                    ->badge()
                    ->sortable()
                    ->state(function (Project $project) {
                        return $project->projectTestRuns()->count();
                    })
                    ->alignCenter(),
                ToggleColumn::make('status')
                    ->label('Is Active')
                    ->disabled(fn() => Auth::user()->hasRole('guest')),
                TextColumn::make('created_at')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Created At'),
                TextColumn::make('updated_at')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Updated At'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->hiddenLabel()
                    ->tooltip('Edit')
                    ->color(Color::Amber)
                    ->visible(fn() => Auth::user()->hasRole('admin')),
                DeleteAction::make()
                    ->hiddenLabel()
                    ->tooltip('Delete')
                    ->visible(fn() => Auth::user()->hasRole('admin')),
            ])
            ->defaultSort('id', 'desc');
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
            'index' => Pages\ListProjects::route('/'),
        ];
    }
}
