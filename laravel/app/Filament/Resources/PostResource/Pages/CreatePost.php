<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Realizar las modificaciones necesarias antes de la creación
        Log::debug("Mutate create form with file relationship");

        // Almacenar el archivo
        $filePath = array_values($data['file']['filepath'])[0];
        $fileSize = Storage::disk('public')->size($filePath);
        $file = File::create([
            'filepath' => $filePath,
            'filesize' => $fileSize,
        ]);

        // Almacenar el ID del archivo
        $data['file_id'] = $file->id;

        return $data;
    }
}
