<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\TestRun;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Enums\TestRunStatusEnum;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\TestRunResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TestRunResource\RelationManagers;
use BackedEnum;
use Filament\Actions\BulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Collection;

class TestRunResource extends Resource
{
    protected static ?string $model = TestRun::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-play';

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Flex::make([
                    Section::make()
                        ->schema([
                            TextInput::make('name')
                                ->label('Name')
                                ->required()
                                ->minLength(3)
                                ->maxLength(255)
                                ->autofocus()
                                ->columnSpan(1),
                            Select::make('project_id')
                                ->label('Project')
                                ->relationship('project', 'name')
                                ->required()
                                ->columnSpan(1),
                            Select::make('assigned_to')
                                ->label('Assigned To')
                                ->relationship('assignedTo', 'name')
                                ->required()
                                ->columnSpan(1),
                            Select::make('status')
                                ->label('Status')
                                ->options(TestRunStatusEnum::class)
                                ->required()
                                ->columnSpan(1),
                            Textarea::make('description')
                                ->label('Description')
                                ->nullable()
                                ->rows(3)
                                ->columnSpanFull(),
                        ])->columns(),
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
                TextColumn::make('project.name')
                    ->searchable(),
                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('assignedTo.name')
                    ->searchable(),
                TextColumn::make('status')
                    ->sortable()
                    ->badge(),
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
                    ->hidden(function () {
                        return Auth::user()->hasRole('guest');
                    }),
                DeleteAction::make()
                    ->hiddenLabel()
                    ->tooltip('Delete')
                    ->hidden(function () {
                        return Auth::user()->hasRole('guest');
                    }),
                ViewAction::make()
                    ->hiddenLabel()
                    ->tooltip('View')
                    ->hidden(function () {
                        return Auth::user()->hasRole('admin') || Auth::user()->hasRole('tester') || Auth::user()->hasRole('developer');
                    }),
            ])
            ->toolbarActions([
                BulkAction::make('delete')
                    ->requiresConfirmation()
                    ->action(function (Collection $records) {
                        $records->each->delete();
                    })
                    ->hidden(function () {
                        return Auth::user()->hasRole('guest') || Auth::user()->hasRole('developer');
                    }),
            ])
            ->defaultSort(fn (Builder $query): Builder => $query
                ->orderByRaw('FIELD(status, "in progress", "pending", "completed")')
            );
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\TestCasesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTestRuns::route('/'),
            'create' => Pages\CreateTestRun::route('/create'),
            'edit' => Pages\EditTestRun::route('/{record}/edit'),
        ];
    }
}
