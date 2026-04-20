<?php
namespace App\Filament\Resources;

use App\Filament\Resources\GuideResource\Pages;
use App\Models\Guide;
use Filament\Forms;
use Filament\Actions;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Tables;
use Filament\Tables\Table;

class GuideResource extends Resource
{
    protected static ?string $model = Guide::class;
    public static function getNavigationGroup(): ?string { return 'Content'; }
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel = 'Guides';
    protected static ?int $navigationSort = 10;

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasRole(['Super Admin', 'Support']);
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Guide Details')
                ->columnSpanFull()
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->required()->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($state, callable $set) =>
                            $set('slug', \Illuminate\Support\Str::slug($state))
                        ),
                    Forms\Components\TextInput::make('slug')
                        ->required()->unique(ignoreRecord: true)->maxLength(255),
                    Forms\Components\Select::make('guide_category_id')
                        ->relationship('category', 'name')
                        ->required()->searchable()->preload(),
                    Forms\Components\DateTimePicker::make('published_at'),
                ])->columns(2),
            Section::make('Media')
                ->columnSpanFull()
                ->schema([
                    Forms\Components\TextInput::make('youtube_url')
                        ->label('YouTube URL')->url()->maxLength(255)
                        ->placeholder('https://www.youtube.com/watch?v=...'),
                    Forms\Components\FileUpload::make('cover_image')
                        ->label('Cover Image')->image()
                        ->disk('public')->directory('guides'),
                ])->columns(2),
            Section::make('Content')
                ->columnSpanFull()
                ->schema([
                    Forms\Components\RichEditor::make('content')
                        ->required()->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('category.name')->sortable(),
                Tables\Columns\IconColumn::make('youtube_url')->label('Video')
                    ->boolean()->trueIcon('heroicon-o-play-circle')->falseIcon('heroicon-o-minus'),
                Tables\Columns\TextColumn::make('published_at')->dateTime()->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
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
            'index'  => Pages\ListGuides::route('/'),
            'create' => Pages\CreateGuide::route('/create'),
            'edit'   => Pages\EditGuide::route('/{record}/edit'),
        ];
    }
}
