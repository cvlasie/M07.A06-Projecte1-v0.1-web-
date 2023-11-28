<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlaceResource\Pages;
use App\Models\Place;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Forms\Components\RichEditor;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Facades\Auth;
use Livewire\TemporaryUploadedFile;

class PlaceResource extends Resource
{
    protected static ?string $model = Place::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('File')
                    ->label(__('File'))
                    ->relationship('file')
                    ->saveRelationshipsWhenHidden()
                    ->schema([
                        Forms\Components\FileUpload::make('filepath')
                            ->label(__('filepath'))
                            ->required() 
                            ->image() 
                            ->maxSize(2048) 
                            ->directory('uploads') 
                            ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                                return time() . '_' . $file->getClientOriginalName();
                            }), 
                        // Camps recurs File...
                    ]),
                Forms\Components\Fieldset::make('Place')
                    ->schema([
                        Forms\Components\Hidden::make('file_id')
                            ->label(__('file_id'))
                            ->required(),
                        Forms\Components\TextInput::make('name')
                            ->label(__('name'))
                            ->required(),
                        Forms\Components\RichEditor::make('description')
                            ->label(__('description'))
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('author_id')
                            ->label(__('author_id'))
                            ->relationship('user', 'name')
                            ->default(Auth::id())
                            ->required(),
                        Forms\Components\DateTimePicker::make('created_date')
                            ->label(__('created_date'))
                            ->default(now())
                            ->disabled(),
                        // Afegeix aquí més camps segons les teves necessitats
                        // Altres camps específics de Place...
                    ]),
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('file_id')
                    ->label(__('file_id')),
                TextColumn::make('name')
                    ->label(__('name')),
                TextColumn::make('description')
                    ->label(__('description')),
                TextColumn::make('author_id')
                    ->label(__('author_id')),
                TextColumn::make('created_date')
                    ->label(__('created_date')),

                // Altres columnes...
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Defineix aquí les relacions si n'hi ha
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlace::route('/'),
            'create' => Pages\CreatePlace::route('/create'),
            'view' => Pages\ViewPlace::route('/{record}'),
            'edit' => Pages\EditPlace::route('/{record}/edit'),
        ];
    }
}