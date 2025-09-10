<?php

namespace App\Filament\Resources;

use BackedEnum;
use App\Models\Role;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Flex;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use App\Filament\Resources\UserResource\Pages;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-users';

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
                                ->required()
                                ->minLength(3)
                                ->maxLength(255)
                                ->autofocus(),
                            TextInput::make('email')
                                ->label('Email')
                                ->email()
                                ->maxLength(255)
                                ->required(),
                            Select::make('role_id')
                                ->relationship('role', 'name')
                                ->label('Role')
                                ->required()
                                ->getOptionLabelFromRecordUsing(fn(Model $record): string => ucfirst($record->name))
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
                    ->label('#'),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(function ($state) {
                        return ucfirst($state);
                    })
                    ->label('Name'),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->label('Email'),
                TextColumn::make('role.name')
                    ->sortable()
                    ->formatStateUsing(function ($state) {
                        return ucfirst($state);
                    })
                    ->label('Role'),
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
            'index' => Pages\ListUsers::route('/'),
        ];
    }
}
