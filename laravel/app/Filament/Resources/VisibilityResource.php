<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VisibilityResource\Pages;
use App\Filament\Resources\VisibilityResource\RelationManagers;
use App\Models\Visibility;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VisibilityResource extends Resource
{
    protected static ?string $model = Visibility::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->required()
                ->label('Name'),
            // Altres camps si són necessaris
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVisibilities::route('/'),
            'create' => Pages\CreateVisibility::route('/create'),
            'edit' => Pages\EditVisibility::route('/{record}/edit'),
        ];
    }    
}
