<?php

namespace App\Filament\Resources\PortfolioProjectResource\RelationManagers;

use Filament\Forms;
use Filament\Actions;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class ImagesRelationManager extends RelationManager
{
    protected static string $relationship = 'images';
    protected static ?string $title = 'Images';

    public function form(Schema $schema): Schema
    {
        return $schema->schema([
            Forms\Components\FileUpload::make('image_path')
                ->label('Image')
                ->image()
                ->directory('portfolio')
                ->required()
                ->columnSpanFull(),
            Forms\Components\TextInput::make('alt_text')
                ->label('Alt Text')
                ->maxLength(255),
            Forms\Components\Select::make('image_type')
                ->options([
                    'cover'      => 'Cover',
                    'screenshot' => 'Screenshot',
                    'mockup'     => 'Mockup',
                    'detail'     => 'Detail',
                ])
                ->default('screenshot'),
            Forms\Components\TextInput::make('sort_order')
                ->numeric()
                ->default(0),
            Forms\Components\Toggle::make('is_featured')
                ->label('Featured')
                ->default(false),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('alt_text')
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('Image')
                    ->height(60)
                    ->width(100),
                Tables\Columns\TextColumn::make('alt_text')
                    ->limit(40),
                Tables\Columns\TextColumn::make('image_type')
                    ->badge(),
                Tables\Columns\IconColumn::make('is_featured')->boolean(),
            ])
            ->headerActions([
                Actions\CreateAction::make()->label('Add Image'),
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
}
