<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\File; 

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $files = File::all(); 

        return response()->json([
            'success' => true,
            'data' => $files
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255', 
            'upload' => 'required|mimes:gif,jpeg,jpg,png|max:2048', 
        ]);
    
        $file = new File();
        $file->nom = $validatedData['nom'];
    
        if ($request->hasFile('upload') && $request->file('upload')->isValid()) {
            $path = $request->file('upload')->store('public/files'); 
            $file->path = $path; 
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Error in file upload'
            ], 500);
        }
    
        $file->save();
    
        return response()->json([
            'success' => true,
            'data' => $file
        ], 201);
    }
    

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $file = File::find($id);

        if ($file) {
            return response()->json([
                'success' => true,
                'data' => $file
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'File not found'
            ], 404);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $file = File::find($id);
        if (!$file) {
            return response()->json([
                'success' => false,
                'message' => 'File not found'
            ], 404);
        }

        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
        ]);

        $file->fill($validatedData);
        $file->save();

        return response()->json([
            'success' => true,
            'data' => $file
        ], 200);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $file = File::find($id);
        if (!$file) {
            return response()->json([
                'success' => false,
                'message' => 'File not found'
            ], 404);
        }

        $file->delete();

        return response()->json([
            'success' => true,
            'message' => 'File deleted successfully'
        ], 200);
    }
    
}
