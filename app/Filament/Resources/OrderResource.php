<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Actions;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Tables;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    public static function getNavigationGroup(): ?string { return 'CRM'; }
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationLabel = 'Orders';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Client Info')
                ->columnSpanFull()
                ->schema([
                    Forms\Components\TextInput::make('client_name')->label('Name')->maxLength(255),
                    Forms\Components\TextInput::make('email')->email()->maxLength(255),
                    Forms\Components\TextInput::make('phone')->tel()->maxLength(255),
                    Forms\Components\Select::make('client_id')
                        ->relationship('client', 'name')
                        ->searchable()->preload(),
                ])->columns(2),
            Section::make('Order Details')
                ->columnSpanFull()
                ->schema([
                    Forms\Components\TextInput::make('domain')->required()->maxLength(255),
                    Forms\Components\Select::make('website_type')
                        ->options([
                            'business'     => 'Business Website',
                            'e-commerce'   => 'E-commerce',
                            'portfolio'    => 'Portfolio',
                            'blog'         => 'Blog',
                            'landing-page' => 'Landing Page',
                            'other'        => 'Other',
                        ])->required(),
                    Forms\Components\Select::make('timeline')
                        ->options([
                            'asap'       => 'ASAP',
                            '1-month'    => '1 Month',
                            '2-3-months' => '2-3 Months',
                            '3-6-months' => '3-6 Months',
                            'flexible'   => 'Flexible',
                        ]),
                    Forms\Components\Select::make('budget_range')
                        ->options([
                            'under-5k' => 'Under $5,000',
                            '5k-10k'   => '$5,000 - $10,000',
                            '10k-25k'  => '$10,000 - $25,000',
                            '25k-50k'  => '$25,000 - $50,000',
                            'over-50k' => 'Over $50,000',
                        ]),
                    Forms\Components\Select::make('status')
                        ->options([
                            'pending'   => 'Pending',
                            'contacted' => 'Contacted',
                            'accepted'  => 'Accepted',
                            'rejected'  => 'Rejected',
                        ])
                        ->required()
                        ->default('pending'),
                    Forms\Components\TextInput::make('price_estimate')
                        ->numeric()->prefix('$')->label('Estimated Total'),
                ])->columns(2),
            Section::make('Project Description')
                ->columnSpanFull()
                ->schema([
                    Forms\Components\Textarea::make('project_description')->rows(4)->columnSpanFull(),
                    Forms\Components\Textarea::make('additional_requirements')->rows(3)->columnSpanFull(),
                ])->collapsed(),
            Section::make('Services & Features')
                ->columnSpanFull()
                ->schema([
                    Forms\Components\CheckboxList::make('services')
                        ->relationship('services', 'name')->columns(2),
                    Forms\Components\CheckboxList::make('features')
                        ->relationship('features', 'name')->columns(2),
                ])->columns(2)->collapsed(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('#')->sortable()->width(60),
                Tables\Columns\TextColumn::make('client_name')->label('Client')->searchable(),
                Tables\Columns\TextColumn::make('domain')->searchable(),
                Tables\Columns\TextColumn::make('price_estimate')->label('Estimate')->money('USD')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\SelectColumn::make('status')
                    ->options([
                        'pending'   => 'Pending',
                        'contacted' => 'Contacted',
                        'accepted'  => 'Accepted',
                        'rejected'  => 'Rejected',
                    ]),
                Tables\Columns\TextColumn::make('created_at')->label('Date')->since()->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Actions\ViewAction::make(),
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view'   => Pages\ViewOrder::route('/{record}'),
            'edit'   => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
