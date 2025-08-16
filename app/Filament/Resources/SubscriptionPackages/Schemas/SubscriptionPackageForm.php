<?php

namespace App\Filament\Resources\SubscriptionPackages\Schemas;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SubscriptionPackageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Package Details')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Textarea::make('description')
                            ->maxLength(1000),

                        TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),

                        Checkbox::make('is_active')
                            ->default(true),
                    ]),

                Section::make('Pricing')
                    ->schema([
                        TextInput::make('monthly_price')
                            ->required()
                            ->numeric()
                            ->prefix('$')
                            ->default(0.00),

                        TextInput::make('yearly_price')
                            ->required()
                            ->numeric()
                            ->prefix('$')
                            ->default(0.00),
                    ]),

                Section::make('API Limits')
                    ->schema([
                        TextInput::make('api_calls_limit')
                            ->numeric()
                            ->label('API Calls Limit')
                            ->helperText('Leave empty for unlimited'),
                    ]),

                Section::make('Features')
                    ->schema([
                        Repeater::make('features')
                            ->schema([
                                TextInput::make('feature')
                                    ->required()
                                    ->maxLength(255),
                            ])
                            ->defaultItems(0)
                            ->addActionLabel('Add Feature')
                            ->collapsible(),
                    ]),
            ]);
    }
}
