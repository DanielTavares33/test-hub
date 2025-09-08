<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use App\Models\Role;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    public static function canAccess(): bool
    {
        return Auth::user()->hasRole('admin');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('name')
                            ->label('Name')
                            ->minLength(3)
                            ->maxLength(255)
                            ->required()
                            ->formatStateUsing(fn (?string $state): ?string => isset($state) ? ucfirst($state) : null)
                            ->autofocus()
                            ->unique(),
                    ]),
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
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
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
            ->actions([
                Tables\Actions\EditAction::make()
                    ->hiddenLabel()
                    ->tooltip('Edit')
                    ->color(Color::Amber),
                Tables\Actions\DeleteAction::make()
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
