<?php

namespace App\Filament\Resources;

use App\Enums\TestCasePriorityEnum;
use App\Enums\TestCaseStatusEnum;
use App\Enums\TestCaseTypeEnum;
use App\Filament\Resources\TestCaseResource\Pages;
use App\Models\TestCase;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class TestCaseResource extends Resource
{
    protected static ?string $model = TestCase::class;

    protected static ?string $navigationIcon = 'carbon-document';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Split::make([
                    Section::make()
                        ->schema([
                            TextInput::make('title')
                                ->label('Title')
                                ->required()
                                ->minLength(3)
                                ->maxLength(255),
                            Textarea::make('description')
                                ->label('Description')
                                ->nullable()
                                ->rows(5)
                                ->maxLength(500)
                                ->minLength(3),
                        ]),
                    Section::make()
                        ->schema([
                            Select::make('project')
                                ->relationship(name: 'project', titleAttribute: 'name', modifyQueryUsing: function ($query) {
                                    # TODO: When editing a record, the disabled project shows the id instead of the name.
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
                    ]),
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
                        }

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
