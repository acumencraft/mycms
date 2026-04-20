<?php
namespace App\Filament\Resources;

use App\Filament\Resources\TeamResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Actions;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Tables;
use Filament\Tables\Table;

class TeamResource extends Resource
{
    protected static ?string $model = User::class;
    public static function getNavigationGroup(): ?string { return 'System'; }
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Team Members';
    protected static ?int $navigationSort = 2;

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasRole('Super Admin');
    }

    // მხოლოდ team roles — Client გამოვრიცხოთ
    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('roles', fn($q) => $q->whereIn('name', ['Admin', 'Super Admin', 'Editor', 'Support']));
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Personal Info')
                ->schema([
                    Forms\Components\TextInput::make('name')->required()->maxLength(255),
                    Forms\Components\TextInput::make('email')->email()->required()->maxLength(255),
                    Forms\Components\Select::make('status')
                        ->options([
                            'active'  => '✅ Active',
                            'blocked' => '🚫 Blocked',
                            'pending' => '⏳ Pending',
                        ])
                        ->default('active')->required(),
                    Forms\Components\Select::make('roles')
                        ->label('Role')
                        ->options([
                            'Admin'      => 'Admin',
                            'Super Admin'=> 'Super Admin',
                            'Editor'     => 'Editor',
                            'Support'    => 'Support',
                        ])
                        ->multiple(false)
                        ->required(),
                ])->columns(2)->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar')
                    ->label('')
                    ->getStateUsing(fn($record) => $record->avatar
                        ? 'avatars/' . $record->avatar
                        : null)
                    ->defaultImageUrl(asset('avatars/default.svg'))
                    ->circular()
                    ->width(36)->height(36),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Role')
                    ->badge()
                    ->color(fn(string $state): string => match($state) {
                        'Super Admin' => 'danger',
                        'Admin'       => 'warning',
                        'Editor'      => 'info',
                        'Support'     => 'success',
                        default       => 'gray',
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match($state) {
                        'active'  => 'success',
                        'blocked' => 'danger',
                        'pending' => 'warning',
                        default   => 'gray',
                    }),
                Tables\Columns\IconColumn::make('email_verified_at')
                    ->label('Verified')
                    ->boolean()
                    ->getStateUsing(fn($record) => !is_null($record->email_verified_at)),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('M j, Y')->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('roles')
                    ->label('Role')
                    ->relationship('roles', 'name')
                    ->options([
                        'Admin'       => 'Admin',
                        'Super Admin' => 'Super Admin',
                        'Editor'      => 'Editor',
                        'Support'     => 'Support',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active'  => 'Active',
                        'blocked' => 'Blocked',
                        'pending' => 'Pending',
                    ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Actions\EditAction::make(),
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
            'index' => Pages\ListTeamMembers::route('/'),
            'edit'  => Pages\EditTeamMember::route('/{record}/edit'),
        ];
    }
}
