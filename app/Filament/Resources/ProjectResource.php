<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'carbon-industry';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
                    ->tooltip(fn ($state) => $state),
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
                    ->disabled(fn () => Auth::user()->hasRole('guest')),
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
            ->actions([
                Tables\Actions\EditAction::make()
                    ->hiddenLabel()
                    ->tooltip('Edit')
                    ->color(Color::Amber)
                    ->visible(fn () => Auth::user()->hasRole('admin')),
                Tables\Actions\DeleteAction::make()
                    ->hiddenLabel()
                    ->tooltip('Delete')
                    ->visible(fn () => Auth::user()->hasRole('admin')),
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
