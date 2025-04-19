<?php

namespace App\Filament\Seller\Widgets;

use App\Models\Order;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class RecentOrder extends BaseWidget
{
    protected array | string | int $columnSpan = 'full';
    protected string $pollingInterval = '2s';

    public function table(Table $table): Table
    {
        $sellerId = Auth::guard('seller')->user()->id;
        $query = Order::where('seller_id', $sellerId)
            ->orderBy('created_at', 'desc');

        // Check for new orders
        $latestOrder = Order::where('seller_id', $sellerId)
            ->where('is_new', true)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($latestOrder) {
            $this->dispatch('play-sound');
            Order::where('seller_id', $sellerId)
                ->where('is_new', true)
                ->update(['is_new' => false]);
        }

        return $table
            ->query($query)
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->label("Name"),
                Tables\Columns\TextColumn::make('user.email')
                    ->searchable()
                    ->label("Email"),
                Tables\Columns\TextColumn::make('total_amount')
                    ->numeric()
                    ->prefix("NRs.")
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('payment_method')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Action::make("Download Invoice")
                    ->url(fn($record) => route('invoice', $record->id), shouldOpenInNewTab: true),
            ])
            ->poll('2s');
    }
}
