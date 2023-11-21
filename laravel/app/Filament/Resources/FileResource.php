<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FileResource\Pages;
use App\Filament\Resources\FileResource\RelationManagers;
use App\Models\File;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\TemporaryUploadedFile;

class FileResource extends Resource
{
    protected static ?string $model = File::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive';

    public static function form(Form $form): Form
    {
        return $form
        // Se está definiendo un campo de carga de archivos (FileUpload) en el formulario.
        ->schema([
            Forms\Components\FileUpload::make('filepath') // Creación del campo de carga de archivos con el nombre 'filepath'.
                ->required() // El campo se establece como obligatorio.
                ->image() // Se especifica que solo se permiten archivos de imagen.
                ->maxSize(2048) // Se establece un límite máximo de tamaño para el archivo cargado (2 MB).
                ->directory('uploads') // Se especifica el directorio en el que se almacenarán los archivos cargados ('uploads').
                ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                    // Se define una función anónima que determina el nombre del archivo almacenado.
                    // En este caso, se está utilizando el tiempo actual concatenado con el nombre original del archivo.
                    return time() . '_' . $file->getClientOriginalName();
                }), // Fin de la configuración del campo de carga de archivos.
            // Forms\Components\TextInput::make('filesize')
            //     ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('filepath'),
                Tables\Columns\TextColumn::make('filesize'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                //
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
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFiles::route('/'),
            'create' => Pages\CreateFile::route('/create'),
            'view' => Pages\ViewFile::route('/{record}'),
            'edit' => Pages\EditFile::route('/{record}/edit'),
        ];
    }    
}
