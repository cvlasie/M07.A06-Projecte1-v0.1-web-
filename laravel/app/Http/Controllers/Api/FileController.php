<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\File;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve and return a list of files
        $files = File::all();
        return response()->json(['success' => true, 'data' => $files]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'upload' => 'required|image|max:1024', // Adjust the max size as needed
        ]);

        // Process file upload and save to the database
        $uploadedFile = $request->file('upload');
        $filepath = $uploadedFile->store('uploads'); // Adjust the storage path as needed
        $filesize = $uploadedFile->getSize();

        $file = new File([
            'filepath' => $filepath,
            'filesize' => $filesize,
        ]);

        $file->save();

        return response()->json(['success' => true, 'data' => $file], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Find and return a specific file
        $file = File::find($id);

        if (!$file) {
            return response()->json(['success' => false, 'message' => 'File not found'], 404);
        }

        return response()->json(['success' => true, 'data' => $file]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the request
        $request->validate([
            'upload' => 'required|image|max:1024', // Adjust the max size as needed
        ]);

        // Find the file
        $file = File::find($id);

        if (!$file) {
            return response()->json(['success' => false, 'message' => 'File not found'], 404);
        }

        // Process file update and save to the database
        $uploadedFile = $request->file('upload');
        $filepath = $uploadedFile->store('uploads'); // Adjust the storage path as needed
        $filesize = $uploadedFile->getSize();

        $file->update([
            'filepath' => $filepath,
            'filesize' => $filesize,
        ]);

        return response()->json(['success' => true, 'data' => $file]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the file
        $file = File::find($id);

        if (!$file) {
            return response()->json(['success' => false, 'message' => 'File not found'], 404);
        }

        // Delete the file from storage
        Storage::delete($file->filepath);

        // Delete the file record from the database
        $file->delete();

        return response()->json(['success' => true, 'message' => 'File deleted']);
    }
}