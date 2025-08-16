<?php

namespace App\Filament\Resources\ApiKeys\Schemas;

use App\Models\User;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ApiKeyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('API Key Details')
                    ->schema([
                        Select::make('user_id')
                            ->label('User')
                            ->options(User::all()->pluck('name', 'id'))
                            ->searchable()
                            ->required(),

                        TextInput::make('name')
                            ->maxLength(255),

                        TextInput::make('key')
                            ->label('API Key')
                            ->maxLength(255)
                            ->default(fn () => \App\Models\ApiKey::generateApiKey())
                            ->disabled(),

                        TextInput::make('prefix')
                            ->maxLength(255),

                        Checkbox::make('is_active')
                            ->default(true),

                        TextInput::make('usage_count')
                            ->numeric()
                            ->default(0)
                            ->disabled(),
                    ]),
            ]);
    }
}
