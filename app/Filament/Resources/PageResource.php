<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Models\Page;
use Filament\Forms;
use Filament\Actions;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Schemas\Components\Section;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;
    public static function getNavigationGroup(): ?string { return 'System'; }
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-document-text';
    protected static ?int $navigationSort = 15;

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasRole('Super Admin');
    }
    protected static ?string $navigationLabel = 'Pages';

    public static function form(Schema $schema): Schema
    {
        $record = $schema->getRecord();
        $slug = $record?->slug;

        $isContact = $slug === 'contact';

        $baseFields = [
            Section::make('General')
                ->columnSpanFull()
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255)
                        ->disabled(fn ($record) => in_array($record?->slug, ['about', 'contact'])),
                    Forms\Components\Select::make('status')
                        ->options(['draft' => 'Draft', 'published' => 'Published'])
                        ->default('published')
                        ->required(),
                ])->columns(3),
            Section::make('SEO')
                ->columnSpanFull()
                ->schema([
                    Forms\Components\TextInput::make('seo_title')->maxLength(255),
                    Forms\Components\Textarea::make('seo_description')->maxLength(500)->rows(2),
                ])->columns(2)->collapsed(),
        ];

        if ($isContact) {
            return $schema->schema(array_merge($baseFields, [
                Section::make('Contact Information')
                    ->columnSpanFull()
                    ->schema([
                        Forms\Components\TextInput::make('contact_phone')
                            ->label('Phone')->maxLength(255),
                        Forms\Components\TextInput::make('contact_email')
                            ->label('Email')->email()->maxLength(255),
                        Forms\Components\TextInput::make('working_hours')
                            ->label('Working Hours')->maxLength(255)
                            ->placeholder('Mon-Fri: 9:00-18:00'),
                        Forms\Components\Textarea::make('contact_address')
                            ->label('Address')->rows(2)->maxLength(500),
                    ])->columns(2),
                Section::make('Google Maps')
                    ->columnSpanFull()
                    ->schema([
                        Forms\Components\Textarea::make('google_maps_embed')
                            ->label('Google Maps Embed Code')
                            ->rows(4)
                            ->placeholder('<iframe src="https://www.google.com/maps/embed?..." ...></iframe>')
                            ->helperText('Google Maps → Share → Embed a map → კოდი აქ ჩასვი')
                    ]),
                Section::make('Page Content')
                    ->columnSpanFull()
                    ->schema([
                        Forms\Components\RichEditor::make('content')
                            ->label('Additional Content (optional)'),
                    ])->collapsed(),
            ]));
        }

        return $schema->schema(array_merge($baseFields, [
            Section::make('Content')
                ->columnSpanFull()
                ->schema([
                    Forms\Components\RichEditor::make('content')
                        ->required(),
                ]),
            Section::make('Hero Section')
                ->columnSpanFull()
                ->schema([
                    Forms\Components\TextInput::make('hero_title')->maxLength(255),
                    Forms\Components\Textarea::make('hero_subtitle')->rows(2)->maxLength(500),
                    Forms\Components\FileUpload::make('hero_image')->image()->directory('pages'),
                    Forms\Components\TextInput::make('hero_button_text')->maxLength(255),
                    Forms\Components\TextInput::make('hero_button_url')->maxLength(255),
                ])->columns(2)->collapsed(),
        ]));
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable(),
                Tables\Columns\TextColumn::make('slug')->badge()->color('gray'),
                Tables\Columns\TextColumn::make('status')->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'published' => 'success',
                        'draft' => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
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
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
