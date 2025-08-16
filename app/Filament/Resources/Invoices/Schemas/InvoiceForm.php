<?php

namespace App\Filament\Resources\Invoices\Schemas;

use App\Models\User;
use App\Models\UserSubscription;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class InvoiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Invoice Details')
                    ->schema([
                        TextInput::make('invoice_number')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Select::make('user_id')
                            ->label('User')
                            ->options(User::all()->pluck('name', 'id'))
                            ->searchable()
                            ->required(),

                        Select::make('user_subscription_id')
                            ->label('Subscription')
                            ->options(UserSubscription::with(['user', 'subscriptionPackage'])
                                ->get()
                                ->mapWithKeys(function ($subscription) {
                                    return [$subscription->id => $subscription->user->name . ' - ' . $subscription->subscriptionPackage->name];
                                }))
                            ->searchable(),

                        Textarea::make('description')
                            ->maxLength(1000),

                        Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'paid' => 'Paid',
                                'failed' => 'Failed',
                                'cancelled' => 'Cancelled',
                                'refunded' => 'Refunded',
                            ])
                            ->required(),

                        TextInput::make('currency')
                            ->default('USD')
                            ->required()
                            ->maxLength(3),
                    ]),

                Section::make('Amounts')
                    ->schema([
                        TextInput::make('amount')
                            ->numeric()
                            ->prefix('$')
                            ->required(),

                        TextInput::make('tax_amount')
                            ->numeric()
                            ->prefix('$')
                            ->default(0),

                        TextInput::make('total_amount')
                            ->numeric()
                            ->prefix('$')
                            ->required(),
                    ]),

                Section::make('Dates')
                    ->schema([
                        DateTimePicker::make('due_date')
                            ->required(),

                        DateTimePicker::make('paid_at'),
                    ]),
            ]);
    }
}
