<?php
namespace App\Filament\Pages;

use App\Models\SiteSetting;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Notifications\Notification;

class ManageSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Settings';
    protected static ?string $title = 'Site Settings';
    protected static ?int $navigationSort = 17;

    public function getView(): string
    {
        return 'filament.pages.manage-settings';
    }

    public ?array $data = [];

    public function mount(): void
    {
        $settings = SiteSetting::pluck('value', 'key')->toArray();
        $this->form->fill($settings);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('General')
                    ->schema([
                        Forms\Components\TextInput::make('site_name')
                            ->label('Site Name')->maxLength(255),
                        Forms\Components\TextInput::make('site_url')
                            ->label('Site URL')
                            ->placeholder(config('agency.url'))
                            ->url()->maxLength(255),
                        Forms\Components\TextInput::make('site_email')
                            ->label('Email')->email()->maxLength(255),
                        Forms\Components\TextInput::make('site_phone')
                            ->label('Phone')->maxLength(255),
                        Forms\Components\Textarea::make('footer_tagline')
                            ->label('Footer Tagline')->rows(2)->columnSpanFull(),
                        Forms\Components\Textarea::make('google_analytics')
                            ->label('Google Analytics Code')
                            ->placeholder('<!-- Google tag (gtag.js) ... -->')
                            ->rows(4)
                            ->columnSpanFull()
                            ->helperText('Google Analytics-ის სრული script კოდი'),
                        Forms\Components\Textarea::make('head_scripts')
                            ->label('Head Scripts / Verification Codes')
                            ->placeholder('<!-- Google Search Console, Bing, etc. verification meta tags or scripts -->')
                            ->rows(4)
                            ->columnSpanFull()
                            ->helperText('Google Search Console, Bing Webmaster, Facebook Domain Verification და სხვა კოდები'),
                    ])->columns(2),

                Section::make('Contact & Location')
                    ->schema([
                        Forms\Components\Textarea::make('contact_address')
                            ->label('Address')->rows(2),
                        Forms\Components\TextInput::make('working_hours')
                            ->label('Working Hours')
                            ->placeholder('Mon-Fri: 9:00-18:00'),
                        Forms\Components\Textarea::make('google_maps_embed')
                            ->label('Google Maps Embed Code')
                            ->rows(3)->columnSpanFull(),
                    ])->columns(2),

                Section::make('Colors & Theme')
                    ->schema([
                        Forms\Components\TextInput::make('color_primary')
                            ->label('Primary Color (HSL)')
                            ->placeholder('221 83% 53%')
                            ->helperText('HSL format: H S% L% — მაგ: 221 83% 53% (ლურჯი), 142 76% 36% (მწვანე), 0 84% 60% (წითელი)')
                            ->suffixIcon('heroicon-o-swatch'),
                        Forms\Components\Toggle::make('dark_mode')
                            ->label('Dark Mode')
                            ->helperText('Enable dark mode')
                            ->onColor('success')
                            ->offColor('gray'),
                    ])->columns(2),

                Section::make('Social Media')
                    ->schema([
                        Forms\Components\TextInput::make('social_facebook')
                            ->label('Facebook')->url()->maxLength(255),
                        Forms\Components\TextInput::make('social_twitter')
                            ->label('X (Twitter)')->url()->maxLength(255),
                        Forms\Components\TextInput::make('social_instagram')
                            ->label('Instagram')->url()->maxLength(255),
                        Forms\Components\TextInput::make('social_linkedin')
                            ->label('LinkedIn')->url()->maxLength(255),
                    ])->columns(2),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        foreach ($data as $key => $value) {
            SiteSetting::updateOrCreate(['key' => $key], ['value' => $value ?? '']);
        }
        Notification::make()->title('Settings saved!')->success()->send();
    }
}
