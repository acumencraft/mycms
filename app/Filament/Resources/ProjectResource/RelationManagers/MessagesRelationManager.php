<?php
namespace App\Filament\Resources\ProjectResource\RelationManagers;

use Filament\Forms;
use Filament\Actions;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class MessagesRelationManager extends RelationManager
{
    protected static string $relationship = 'messages';
    protected static ?string $title = 'Messages';

    public function form(Schema $schema): Schema
    {
        return $schema->schema([
            Forms\Components\Textarea::make('message')
                ->required()
                ->rows(3)
                ->columnSpanFull()
                ->placeholder('Type your message to the client...'),
            Forms\Components\Hidden::make('sender_id')
                ->default(fn() => Auth::id()),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('message')
            ->defaultSort('created_at', 'asc')
            ->columns([
                Tables\Columns\TextColumn::make('sender.name')
                    ->label('From')
                    ->badge()
                    ->color(fn($record) => $record->sender_id === Auth::id() ? 'info' : 'gray'),
                Tables\Columns\TextColumn::make('message')
                    ->label('Message')
                    ->wrap(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Time')
                    ->dateTime('M j, Y H:i')
                    ->sortable(),
            ])
            ->headerActions([
                Actions\CreateAction::make()
                    ->label('Send Message')
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['sender_id'] = Auth::id();
                        return $data;
                    }),
            ])
            ->actions([
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([]);
    }
}
