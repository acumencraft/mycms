<?php
namespace App\Filament\Resources\ActivityLogs;

use App\Filament\Resources\ActivityLogs\Pages\ListActivityLogs;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Spatie\Activitylog\Models\Activity;

class ActivityLogResource extends Resource
{
    protected static ?string $model = Activity::class;
    protected static ?string $navigationLabel = 'Activity Log';
    protected static ?int $navigationSort = 99;

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasRole(['Super Admin', 'Admin', 'Support']);
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Operations';
    }

    public static function getNavigationIcon(): string|\BackedEnum|null
    {
        return 'heroicon-o-clipboard-document-list';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('causer.name')
                    ->label('User')
                    ->default('System')
                    ->searchable(),
                TextColumn::make('description')
                    ->label('Action')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('subject_type')
                    ->label('Model')
                    ->formatStateUsing(fn($state) => $state ? class_basename($state) : '-'),
                TextColumn::make('subject_id')
                    ->label('ID'),
                TextColumn::make('properties')
                    ->label('Details')
                    ->formatStateUsing(fn($state) => $state ? json_encode($state) : '-')
                    ->wrap()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Time')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([])
            ->actions([])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListActivityLogs::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
