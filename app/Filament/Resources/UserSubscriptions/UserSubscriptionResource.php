<?php

namespace App\Filament\Resources\UserSubscriptions;

use App\Filament\Resources\UserSubscriptions\Pages\CreateUserSubscription;
use App\Filament\Resources\UserSubscriptions\Pages\EditUserSubscription;
use App\Filament\Resources\UserSubscriptions\Pages\ListUserSubscriptions;
use App\Filament\Resources\UserSubscriptions\Schemas\UserSubscriptionForm;
use App\Filament\Resources\UserSubscriptions\Tables\UserSubscriptionsTable;
use App\Models\UserSubscription;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UserSubscriptionResource extends Resource
{
    protected static ?string $model = UserSubscription::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return UserSubscriptionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UserSubscriptionsTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('user', function (Builder $query) {
                $query->where('email', '!=', 'admin@example.com');
            });
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
            'index' => ListUserSubscriptions::route('/'),
            'create' => CreateUserSubscription::route('/create'),
            'edit' => EditUserSubscription::route('/{record}/edit'),
        ];
    }
}
