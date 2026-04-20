<?php
namespace App\Filament\Resources;

use App\Filament\Resources\PublicationResource\Pages;
use App\Models\Publication;
use Filament\Forms;
use Filament\Actions;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Tables;
use Filament\Tables\Table;

class PublicationResource extends Resource
{
    protected static ?string $model = Publication::class;
    public static function getNavigationGroup(): ?string { return 'Content'; }
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Publications';
    protected static ?int $navigationSort = 8;

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasRole(['Super Admin', 'Editor']);
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Publication Details')
                ->columnSpanFull()
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->required()->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($state, callable $set) =>
                            $set('slug', \Illuminate\Support\Str::slug($state))
                        ),
                    Forms\Components\TextInput::make('slug')
                        ->unique(ignoreRecord: true)->maxLength(255),
                    Forms\Components\Select::make('status')
                        ->options(['draft'=>'Draft','published'=>'Published','archived'=>'Archived'])
                        ->default('draft')->required(),
                    Forms\Components\DateTimePicker::make('published_at'),
                    Forms\Components\Toggle::make('is_published')->default(false),
                ])->columns(2),
            Section::make('Categories & Tags')
                ->columnSpanFull()
                ->schema([
                    Forms\Components\Select::make('categories')
                        ->relationship('categories', 'name')
                        ->multiple()->preload(),
                    Forms\Components\Select::make('tags')
                        ->relationship('tags', 'name')
                        ->multiple()->preload(),
                ])->columns(2),
            Section::make('Cover Image')
                ->columnSpanFull()
                ->schema([
                    Forms\Components\FileUpload::make('cover_image')
                        ->image()->disk('public')->directory('publications'),
                ])->columns(2),
            Section::make('Excerpt')
                ->columnSpanFull()
                ->schema([
                    Forms\Components\Textarea::make('excerpt')
                        ->rows(3)->maxLength(500)->columnSpanFull()
                ]),
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
                Tables\Columns\ImageColumn::make('cover_image')->disk('public')->height(40)->width(60),
                Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('status')->badge()
                    ->color(fn(string $state) => match($state) {
                        'published' => 'success', 'draft' => 'warning', default => 'gray'
                    }),
                Tables\Columns\IconColumn::make('is_published')->boolean(),
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
            'index'  => Pages\ListPublications::route('/'),
            'create' => Pages\CreatePublication::route('/create'),
            'edit'   => Pages\EditPublication::route('/{record}/edit'),
        ];
    }
}
