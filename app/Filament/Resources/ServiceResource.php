<?php
namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
use Filament\Forms;
use Filament\Actions;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Tables;
use Filament\Tables\Table;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;
    public static function getNavigationGroup(): ?string { return 'Content'; }
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-cog';
    protected static ?string $navigationLabel = 'Services';
    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Service Details')
                ->columnSpanFull()
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()->maxLength(255),
                    Forms\Components\TextInput::make('icon')
                        ->maxLength(255)
                        ->placeholder('code, palette, rocket...')
                        ->helperText('Font Awesome icon name without "fa-" prefix'),
                    Forms\Components\TextInput::make('base_price')
                        ->label('Base Price')->numeric()->prefix('$'),
                    Forms\Components\TextInput::make('button_text')
                        ->maxLength(255)->default('Get Started'),
                    Forms\Components\Toggle::make('status')->default(true),
                    Forms\Components\Toggle::make('is_active')->default(true),
                    Forms\Components\Textarea::make('description')
                        ->rows(3)->columnSpanFull(),
                ])->columns(2),

            Section::make('Service Image')
                ->columnSpanFull()
                ->schema([
                    Forms\Components\FileUpload::make('image')
                        ->label('Service Image')->image()
                        ->disk('public')->directory('services'),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')->height(40)->width(60),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('base_price')->money('USD'),
                Tables\Columns\TextColumn::make('icon')->badge()->color('gray'),
                Tables\Columns\IconColumn::make('status')->boolean(),
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([Actions\DeleteBulkAction::make()]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit'   => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
