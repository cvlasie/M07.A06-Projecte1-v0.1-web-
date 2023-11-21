<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use App\Models\File; 
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\TemporaryUploadedFile;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-plus';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('File')
                    ->relationship('file')
                    ->saveRelationshipsWhenHidden()
                    ->schema([
                        Forms\Components\FileUpload::make('filepath') // Puedes agregar más campos aquí si es necesario
                            ->required()
                            ->image()
                            ->maxSize(2048)
                            ->directory('uploads')
                            ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                                return time() . '_' . $file->getClientOriginalName();
                            }),
                    ]),
                Forms\Components\Fieldset::make('Post / Place')
                    ->schema([
                        Forms\Components\Hidden::make('file_id'),
                        Select::make('author_id')
                            ->relationship('user', 'name')
                            ->default(auth()->id())
                            ->required(),
                        Forms\Components\RichEditor::make('body')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('latitude')
                            ->required(),
                        Forms\Components\TextInput::make('longitude')
                            ->required(),
                        Forms\Components\DateTimePicker::make('created_date'),
                    ]),
            ]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        Log::debug("Mutate create form with file relationship");

        // Almacenar el archivo
        $filePath = array_values($this->data['file']['filepath'])[0];
        $fileSize = Storage::disk('public')->size($filePath);
        $file = File::create([
            'filepath' => $filePath,
            'filesize' => $fileSize,
        ]);

        // Almacenar el ID del archivo
        $data['file_id'] = $file->id;

        return $data;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('file_id'),
                Tables\Columns\TextColumn::make('author_id'),
                Tables\Columns\TextColumn::make('body'),
                Tables\Columns\TextColumn::make('latitude'),
                Tables\Columns\TextColumn::make('longitude'),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'view' => Pages\ViewPost::route('/{record}'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
