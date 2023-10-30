<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("files.index", [
            "files" => File::all()
        ]);
    } 

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("files.create");
    } 

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar fitxer
        $validatedData = $request->validate([
            'upload' => 'required|mimes:gif,jpeg,jpg,png|max:1024'
        ]);
       
        // Obtenir dades del fitxer
        $upload = $request->file('upload');
        $fileName = $upload->getClientOriginalName();
        $fileSize = $upload->getSize();
        \Log::debug("Storing file '{$fileName}' ($fileSize)...");
 
 
        // Pujar fitxer al disc dur
        $uploadName = time() . '_' . $fileName;
        $filePath = $upload->storeAs(
            'uploads',      // Path
            $uploadName ,   // Filename
            'public'        // Disk
        );
       
        if (\Storage::disk('public')->exists($filePath)) {
            \Log::debug("Disk storage OK");
            $fullPath = \Storage::disk('public')->path($filePath);
            \Log::debug("File saved at {$fullPath}");
            // Desar dades a BD
            $file = File::create([
                'filepath' => $filePath,
                'filesize' => $fileSize,
            ]);
            \Log::debug("DB storage OK");
            // Patró PRG amb missatge d'èxit
            return redirect()->route('files.show', $file)
                ->with('success', 'File successfully saved');
        } else {
            \Log::debug("Disk storage FAILS");
            // Patró PRG amb missatge d'error
            return redirect()->route("files.create")
                ->with('error', 'ERROR uploading file');
        }
    } 

    /**
     * Display the specified resource.
     */
    public function show(File $file)
    {
        // Obtener la ruta del archivo almacenada en la base de datos
        $filePath = $file->filepath;
    
        // Verificar si el archivo existe en el disco
        if (Storage::disk('public')->exists($filePath)) {
            // Construir la URL del archivo utilizando el método asset
            $fileUrl = asset("storage/{$filePath}");
    
            return view("files.show", [
                'file' => $file,
                'fileUrl' => $fileUrl,
            ]);
        } else {
            return redirect()->route('files.index')->with('error', 'Archivo no encontrado');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(File $file)
    {
        return view('files.edit', ['file' => $file]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, File $file)
    {
        // Validar que el archivo sea una imagen (jpg, png o gif) y que pese menos de 2MB
        $validatedData = $request->validate([
            'newFile' => 'required|image|mimes:jpg,png,gif|max:2048', // Max size in kilobytes (2MB)
        ]);
    
        // Obtener el nuevo archivo
        $newFile = $request->file('newFile');
        $fileName = $newFile->getClientOriginalName();
        $fileSize = $newFile->getSize();
    
        // Almacenar el nuevo archivo en el disco public (directorio storage/public/uploads)
        $newFileName = time() . '_' . $fileName;
        $newFilePath = $newFile->storeAs(
            'uploads',    // Ruta
            $newFileName, // Nombre de archivo
            'public'      // Disco
        );
    
        if (Storage::disk('public')->exists($newFilePath)) {
            // Eliminar el archivo anterior
            Storage::disk('public')->delete($file->filepath);
    
            // Actualizar los datos del archivo en la base de datos
            $file->filepath = $newFilePath;
            $file->filesize = $fileSize;
            $file->save();
    
            return redirect()->route('files.show', $file)->with('success', 'Archivo actualizado correctamente');
        } else {
            return redirect()->route('files.edit', $file)->with('error', 'Error al actualizar el archivo');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(File $file)
    {
        // Obtener la ruta del archivo almacenada en la base de datos
        $filePath = $file->filepath;
    
        if (Storage::disk('public')->exists($filePath)) {
            // Eliminar el archivo del disco
            Storage::disk('public')->delete($filePath);
    
            // Eliminar el registro de la base de datos
            $file->delete();
    
            return redirect()->route('files.index')->with('success', 'Archivo eliminado correctamente');
        } else {
            return redirect()->route('files.show', $file)->with('error', 'Error al eliminar el archivo');
        }
    }
}
