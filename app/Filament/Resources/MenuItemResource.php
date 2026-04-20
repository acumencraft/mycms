<?php
namespace App\Filament\Resources;

use App\Filament\Resources\MenuItemResource\Pages;
use App\Models\MenuItem;
use Filament\Forms;
use Filament\Actions;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Tables;
use Filament\Tables\Table;

class MenuItemResource extends Resource
{
    protected static ?string $model = MenuItem::class;
    public static function getNavigationGroup(): ?string { return 'System'; }
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-bars-3';
    protected static ?string $navigationLabel = 'Menu Items';
    protected static ?int $navigationSort = 14;

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasRole('Super Admin');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Menu Item')
                ->columnSpanFull()
                ->schema([
                    Forms\Components\TextInput::make('label')
                        ->required()->maxLength(255)->placeholder('e.g., About Us'),
                    Forms\Components\TextInput::make('url')
                        ->required()->maxLength(255)->placeholder('/about'),
                    Forms\Components\Select::make('location')
                        ->options([
                            'header' => 'Header Navigation',
                            'footer' => 'Footer Quick Links',
                            'bottom' => 'Footer Bottom Bar',
                        ])
                        ->default('header')->required(),
                    Forms\Components\TextInput::make('position')
                        ->numeric()->default(0)
                        ->helperText('Lower = first'),
                    Forms\Components\Toggle::make('is_active')->default(true),
                    Forms\Components\Toggle::make('open_in_new_tab')->default(false),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('position')->sortable()->width(60),
                Tables\Columns\TextColumn::make('label')->searchable(),
                Tables\Columns\TextColumn::make('url')->limit(40),
                Tables\Columns\TextColumn::make('location')->badge()
                    ->color(fn($state) => match($state) {
                        'header' => 'info', 'footer' => 'gray', 'bottom' => 'warning', default => 'gray'
                    }),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
            ])
            ->defaultSort('position')
            ->reorderable('position')
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
            'index'  => Pages\ListMenuItems::route('/'),
            'create' => Pages\CreateMenuItem::route('/create'),
            'edit'   => Pages\EditMenuItem::route('/{record}/edit'),
        ];
    }
}
