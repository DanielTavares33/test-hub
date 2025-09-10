<?php

namespace App\Filament\Resources;

use BackedEnum;
use Filament\Tables;
use App\Models\TestCase;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use App\Enums\TestCaseTypeEnum;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Resource;
use App\Enums\TestCaseStatusEnum;
use Filament\Actions\DeleteAction;
use Filament\Support\Colors\Color;
use App\Enums\TestCasePriorityEnum;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\MarkdownEditor;
use App\Filament\Resources\TestCaseResource\Pages;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Section;

class TestCaseResource extends Resource
{
    protected static ?string $model = TestCase::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-pencil';

    public static function canEdit($record): bool
    {
        return ! Auth::user()->hasRole('guest');
    }

    public static function canCreate(): bool
    {
        return ! Auth::user()->hasRole('guest');
    }

    public static function canDelete($record): bool
    {
        return ! Auth::user()->hasRole('guest');
    }

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
                                ->columnSpan(1),
                            TextInput::make('title')
                                ->label('Title')
                                ->required()
                                ->minLength(3)
                                ->maxLength(255)
                                ->columnSpan(1),
                            Textarea::make('description')
                                ->label('Description')
                                ->nullable()
                                ->rows(5)
                                ->maxLength(500)
                                ->minLength(3)
                                ->columnSpanFull(),
                        ])->columns(),
                    Section::make()
                        ->schema([
                            Select::make('project_id')
                                ->relationship(name: 'project', titleAttribute: 'name', modifyQueryUsing: function ($query, $record) {
                                    if ($record) {
                                        return $query->where('id', $record->project_id);
                                    }

                                    return $query->where('status', true);
                                })
                                ->required()
                                ->columnSpanFull(),
                            Select::make('type')
                                ->options(TestCaseTypeEnum::class)
                                ->required()
                                ->columnSpan(1),
                            Select::make('status')
                                ->options(TestCaseStatusEnum::class)
                                ->required()
                                ->columnSpan(1)
                                ->default(TestCaseStatusEnum::Draft),
                            Select::make('priority')
                                ->options(TestCasePriorityEnum::class)
                                ->required()
                                ->columnSpan(1)
                                ->default(TestCasePriorityEnum::Low),
                            Select::make('createdBy')
                                ->relationship(name: 'createdBy', titleAttribute: 'name')
                                ->default(Auth::id())
                                ->disabled(function () {
                                    return ! Auth::user()->hasRole('admin');
                                })
                                ->columnSpan(1),
                        ])->columns(),
                ])->columnSpanFull(),
                Section::make('Steps')
                    ->description('Write the steps to reproduce the test case.')
                    ->schema([
                        Repeater::make('testCaseSteps')
                            ->hiddenLabel()
                            ->relationship()
                            ->reorderable()
                            ->columns()
                            ->schema([
                                MarkdownEditor::make('description')
                                    ->label('Step')
                                    ->toolbarButtons([
                                        'bold',
                                        'italic',
                                        'bulletList',
                                        'orderedList',
                                        'link',
                                        'codeBlock',
                                        'table'
                                    ])
                                    ->required()
                                    ->minLength(3)
                                    ->columnSpan(1),
                                MarkdownEditor::make('expected_result')
                                    ->label('Expected Result')
                                    ->toolbarButtons([
                                        'bold',
                                        'italic',
                                        'bulletList',
                                        'orderedList',
                                        'link',
                                        'codeBlock',
                                        'table'
                                    ])
                                    ->required()
                                    ->minLength(3)

                                    ->columnSpan(1),
                            ])
                            ->addActionLabel('Add Step'),
                    ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('#')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('type')
                    ->badge()
                    ->color('gray')
                    ->formatStateUsing(function ($state) {
                        if ($state->value === 'e2e') {
                            return 'E2E';
                        }

                        return ucfirst($state->value);
                    })
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Name')
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
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
            ])
            ->defaultSort(fn (Builder $query): Builder => $query
                ->orderByRaw('FIELD(status, "draft", "active", "pending", "failed", "passed")')
            )
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(TestCaseStatusEnum::class)
                    ->label('Status'),
                Tables\Filters\SelectFilter::make('priority')
                    ->options(TestCasePriorityEnum::class)
                    ->label('Priority'),
                Tables\Filters\SelectFilter::make('type')
                    ->options(TestCaseTypeEnum::class)
                    ->label('Type'),
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
