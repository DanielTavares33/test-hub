<?php

namespace App\Filament\Resources;

use BackedEnum;
use App\Models\Role;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Actions\DeleteAction;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\Auth;
use Filament\Schemas\Components\Flex;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use App\Filament\Resources\RoleResource\Pages;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-identification';

    public static function canAccess(): bool
    {
        return Auth::user()->hasRole('admin');
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
                                ->minLength(3)
                                ->maxLength(255)
                                ->required()
                                ->formatStateUsing(fn(?string $state): ?string => isset($state) ? ucfirst($state) : null)
                                ->autofocus()
                                ->unique(),
                        ]),
                ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable()
                    ->label('#'),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn(string $state): string => ucfirst($state))
                    ->label('Name'),
                TextColumn::make('created_at')
                    ->sortable()
                    ->label('Created At'),
                TextColumn::make('updated_at')
                    ->sortable()
                    ->label('Updated At'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->hiddenLabel()
                    ->tooltip('Edit')
                    ->color(Color::Amber),
                DeleteAction::make()
                    ->hiddenLabel()
                    ->tooltip('Delete'),
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
            'index' => Pages\ListRoles::route('/'),
        ];
    }
}
