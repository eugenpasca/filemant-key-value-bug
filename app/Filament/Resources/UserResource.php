<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('email')
                    ->email(),

                Forms\Components\Select::make('field_template')
                    ->options([
                        'no-fields' => 'No fields',
                        'many-fields' => 'Many Fields',
                    ])
                    ->live()
                    ->afterStateUpdated(function (Forms\Set $set, ?string $state) {
                        if ($state == 'no-fields') {
                            return $set('fields', []);
                        } else {
                            return $set('fields', [
                                'key_1' => 'value 1',
                                'key_2' => 'value 2',
                                'key_3' => 'value 3',
                            ]);
                        }
                    }),
                Forms\Components\KeyValue::make('fields')
                    ->default([]),
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('email'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
