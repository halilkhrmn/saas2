<?php

namespace App\Filament\Resources\UserSubscriptions\Schemas;

use App\Models\SubscriptionPackage;
use App\Models\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserSubscriptionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Subscription Details')
                    ->schema([
                        Select::make('user_id')
                            ->label('User')
                            ->options(User::all()->pluck('name', 'id'))
                            ->searchable()
                            ->required(),

                        Select::make('subscription_package_id')
                            ->label('Package')
                            ->options(SubscriptionPackage::all()->pluck('name', 'id'))
                            ->searchable()
                            ->required(),

                        Select::make('billing_cycle')
                            ->options([
                                'monthly' => 'Monthly',
                                'yearly' => 'Yearly',
                            ])
                            ->required(),

                        Select::make('status')
                            ->options([
                                'active' => 'Active',
                                'cancelled' => 'Cancelled',
                                'expired' => 'Expired',
                                'pending' => 'Pending',
                            ])
                            ->required(),

                        TextInput::make('price_paid')
                            ->numeric()
                            ->prefix('$')
                            ->required(),

                        TextInput::make('api_calls_used')
                            ->numeric()
                            ->default(0),
                    ]),

                Section::make('Dates')
                    ->schema([
                        DateTimePicker::make('starts_at')
                            ->required(),

                        DateTimePicker::make('ends_at')
                            ->required(),

                        DateTimePicker::make('cancelled_at'),
                    ]),
            ]);
    }
}
