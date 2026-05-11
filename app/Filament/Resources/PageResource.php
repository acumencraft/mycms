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
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationLabel = 'Pages';

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasRole('Super Admin');
    }

    public static function form(Schema $schema): Schema
    {
        $record = $schema->getRecord();
        $slug = $record?->slug;

        $modulePages = ['blog', 'portfolio', 'services', 'guides', 'shop'];
        $contentPages = ['about', 'contact', 'privacy-policy', 'terms'];
        $isModule = in_array($slug, $modulePages);
        $isContent = in_array($slug, $contentPages);
        $isHome = $slug === 'home';
        $isContact = $slug === 'contact';

        $sections = [];

        // General
        $sections[] = Section::make('General')
            ->columnSpanFull()
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Admin Label')
                    ->helperText('მხოლოდ admin მენიუში ჩანს')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->disabled(fn ($record) => $record?->slug !== null),
                Forms\Components\Select::make('status')
                    ->options(['draft' => 'Draft', 'published' => 'Published'])
                    ->default('published')
                    ->required(),
            ])->columns(3);

        // SEO
        $sections[] = Section::make('SEO')
            ->columnSpanFull()
            ->schema([
                Forms\Components\TextInput::make('seo_title')->maxLength(255),
                Forms\Components\Textarea::make('seo_description')->maxLength(500)->rows(2),
            ])->columns(2)->collapsed();

        // Page Heading — ყველა გვერდზე
        $headingSchema = [
            Forms\Components\TextInput::make('page_title')
                ->label('Page Title')
                ->helperText('გვერდზე ჩასაჩვენებელი სათაური (h1)')
                ->maxLength(255),
            Forms\Components\Textarea::make('page_subtitle')
                ->label('Page Subtitle')
                ->helperText('გვერდის ქვესათაური')
                ->rows(2)
                ->maxLength(500),
        ];

        if ($isModule) {
            $headingSchema[] = Forms\Components\TextInput::make('items_count')
                ->label('Items to Show')
                ->helperText('რამდენი ელემენტი გამოჩნდეს გვერდზე')
                ->numeric()
                ->default(9)
                ->minValue(1)
                ->maxValue(50);
        }

        $sections[] = Section::make('Page Heading')
            ->columnSpanFull()
            ->description('სათაური და ქვესათაური რომელიც გვერდზე ჩანს')
            ->schema($headingSchema)
            ->columns(2);

        // Content — content pages + home
        if ($isContent || $isHome || !$isModule) {
            $sections[] = Section::make('Content')
                ->columnSpanFull()
                ->schema([
                    Forms\Components\RichEditor::make('content'),
                ]);
        }

        // Contact fields
        if ($isContact) {
            $sections[] = Section::make('Contact Information')
                ->columnSpanFull()
                ->schema([
                    Forms\Components\TextInput::make('contact_phone')->label('Phone')->maxLength(255),
                    Forms\Components\TextInput::make('contact_email')->label('Email')->email()->maxLength(255),
                    Forms\Components\TextInput::make('working_hours')->label('Working Hours')->maxLength(255),
                    Forms\Components\Textarea::make('contact_address')->label('Address')->rows(2)->maxLength(500),
                ])->columns(2);

            $sections[] = Section::make('Google Maps')
                ->columnSpanFull()
                ->schema([
                    Forms\Components\Textarea::make('google_maps_embed')
                        ->label('Google Maps Embed Code')
                        ->rows(4)
                        ->placeholder('<iframe src="https://www.google.com/maps/embed?..." ...></iframe>'),
                ]);
        }

        // Hero Section — მხოლოდ home
        if ($isHome) {
            $sections[] = Section::make('Hero Section')
                ->columnSpanFull()
                ->schema([
                    Forms\Components\TextInput::make('hero_title')->maxLength(255)->columnSpanFull(),
                    Forms\Components\Textarea::make('hero_subtitle')->rows(2)->maxLength(500)->columnSpanFull(),
                    Forms\Components\FileUpload::make('hero_image')->image()->directory('pages')->columnSpanFull(),
                    Forms\Components\TextInput::make('hero_button_text')->maxLength(255),
                    Forms\Components\TextInput::make('hero_button_url')->maxLength(255),
                ])->columns(2)->collapsed();
        }

        return $schema->schema($sections);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable(),
                Tables\Columns\TextColumn::make('slug')->badge()->color('gray'),
                Tables\Columns\TextColumn::make('page_title')->label('Page Title')->searchable(),
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
