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
        $files = File::all();
        return response()->json(['success' => true, 'data' => $files]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'upload' => 'required|image|max:1024', 
        ]);

        $uploadedFile = $request->file('upload');
        $filepath = $uploadedFile->store('uploads', 'public');
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
        $file = File::find($id);
        if (!$file) {
            return response()->json(['success' => false, 'message' => 'File not found'], 404);
        }

        $request->validate([
            'upload' => 'required|image|max:1024', 
        ]);

        $uploadedFile = $request->file('upload');
        $filepath = $uploadedFile->store('uploads', 'public'); 
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
        $file = File::find($id);

        if (!$file) {
            return response()->json(['success' => false, 'message' => 'File not found'], 404);
        }

        Storage::disk('public')->delete($file->filepath);

        $file->delete();

        return response()->json(['success' => true, 'message' => 'File deleted']);
    }

    public function update_workaround(Request $request, $id)
    {
        return $this->update($request, $id);
    }
}