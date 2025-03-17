<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;


class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('seller_name')->label('Имя продавца')->required(),
                TextInput::make('phone_number')
                    ->label('Номер телефона')
                    ->tel()
                    ->required(),
                TextInput::make('shop_name')->label('Название магазина'),
                Textarea::make('products')->label('Товары'),
                TextInput::make('district')->label('Район'),
                TextInput::make('address')->label('Адрес'),
                TextInput::make('location')->label('Локация (ссылка)')->url(),
                Textarea::make('comment')->label('Комментарий'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('seller_name')->label('Имя продавца')->sortable()->searchable(),
                TextColumn::make('phone_number')
                    ->label('Номер телефона')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('shop_name')->label('Название магазина')->sortable()->searchable(),
                TextColumn::make('products')->label('Товары')->limit(30),
                TextColumn::make('district')->label('Район')->sortable(),
                TextColumn::make('address')->label('Адрес'),
                TextColumn::make('location')
                    ->label('Локация')
                    ->url(fn ($record) => "https://maps.google.com/maps?q={$record->location}")
                    ->openUrlInNewTab(),
                TextColumn::make('comment')->label('Комментарий')->limit(50),
            ])
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make(), // Добавляем кнопку "View"
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'view-contact' => Pages\ViewCustomerContact::route('/{record}/contact'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
