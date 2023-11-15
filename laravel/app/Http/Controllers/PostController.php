<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    private bool $_pagination = true;

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


     public function like(Request $request, Post $post)
     {
         $user = auth()->user();
     
         // Verificar si el usuario ya le dio like al post
         if (!$post->likes()->where('user_id', $user->id)->exists()) {
             // Agregar like
             $post->likes()->attach($user->id);
             $message = 'Post liked successfully';
         } else {
             $message = 'Post already liked by the user';
         }
     
         // Actualizar los likes_count en el modelo Post
         $post->loadCount('likes');
     
         // Obtén el usuario autenticado (si estás utilizando autenticación)
         $user = auth()->user();
     
         // Verifica si el usuario autenticado ha dado like al post
         $liked = $user ? $post->likes->contains($user->id) : false;
     
         return view("posts.show", [
             'post'   => $post,
             'file'   => $post->file,
             'author' => $post->user,
             'liked'  => $liked,
             'message' => $message,
         ]);
     }
     
     public function unlike(Request $request, Post $post)
     {
         $user = auth()->user();
     
         // Verificar si el usuario le dio like al post
         if ($post->likes()->where('user_id', $user->id)->exists()) {
             // Eliminar like
             $post->likes()->detach($user->id);
             $message = 'Post unliked successfully';
         } else {
             $message = 'User has not liked the post';
         }
     
         // Actualizar los likes_count en el modelo Post
         $post->loadCount('likes');
     
         // Obtén el usuario autenticado (si estás utilizando autenticación)
         $user = auth()->user();
     
         // Verifica si el usuario autenticado ha dado like al post
         $liked = $user ? $post->likes->contains($user->id) : false;
     
         return view("posts.show", [
             'post'   => $post,
             'file'   => $post->file,
             'author' => $post->user,
             'liked'  => $liked,
             'message' => $message,
         ]);
     }     

    public function index(Request $request)
    {
        $collectionQuery = Post::withCount('likes')->orderBy('created_date', 'desc');

        // Filter?
        if ($search = $request->get('search')) {
            $collectionQuery->where('body', 'like', "%{$search}%");
        }
        
        // Pagination
        $posts = $this->_pagination 
            ? $collectionQuery->paginate(5)->withQueryString() 
            : $collectionQuery->get();
        
        return view("posts.index", [
            "posts" => $posts,
            "search" => $search
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
        return view("posts.create");  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validar dades del formulari
        $validatedData = $request->validate([
            'body'      => 'required',
            'upload'    => 'required|mimes:gif,jpeg,jpg,png,mp4|max:2048',
            'latitude'  => 'required',
            'longitude' => 'required',
        ]);
        
        // Obtenir dades del formulari
        $body          = $request->get('body');
        $upload        = $request->file('upload');
        $latitude      = $request->get('latitude');
        $longitude     = $request->get('longitude');

        // Desar fitxer al disc i inserir dades a BD
        $file = new File();
        $fileOk = $file->diskSave($upload);

        if ($fileOk) {
            // Desar dades a BD
            Log::debug("Saving post at DB...");
            $post = Post::create([
                'body'      => $body,
                'file_id'   => $file->id,
                'latitude'  => $latitude,
                'longitude' => $longitude,
                'author_id' => auth()->user()->id,
            ]);
            Log::debug("DB storage OK");
            // Patró PRG amb missatge d'èxit
            return redirect()->route('posts.show', $post)
                ->with('success', __('Post successfully saved'));
        } else {
            // Patró PRG amb missatge d'error
            return redirect()->route("posts.create")
                ->with('error', __('ERROR Uploading file'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $post->loadCount('likes'); 
    
        // Obtén el usuario autenticado (si estás utilizando autenticación)
        $user = auth()->user();
    
        // Verifica si el usuario autenticado ha dado like al post
        $liked = $user ? $post->likes->contains($user->id) : false;
    
        return view("posts.show", [
            'post'   => $post,
            'file'   => $post->file,
            'author' => $post->user,
            'liked'  => $liked,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view("posts.edit", [
            'post'   => $post,
            'file'   => $post->file,
            'author' => $post->user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        // Validar dades del formulari
        $validatedData = $request->validate([
            'body'      => 'required',
            'upload'    => 'nullable|mimes:gif,jpeg,jpg,png,mp4|max:2048',
            'latitude'  => 'required',
            'longitude' => 'required',
        ]);

        // Obtenir dades del formulari
        $body      = $request->get('body');
        $upload    = $request->file('upload');
        $latitude  = $request->get('latitude');
        $longitude = $request->get('longitude');

        // Desar fitxer (opcional)
        if (is_null($upload) || $post->file->diskSave($upload)) {
            // Actualitzar dades a BD
            Log::debug("Updating DB...");
            $post->body      = $body;
            $post->latitude  = $latitude;
            $post->longitude = $longitude;
            $post->save();
            Log::debug("DB storage OK");
            // Patró PRG amb missatge d'èxit
            return redirect()->route('posts.show', $post)
                ->with('success', __('Post successfully saved'));
        } else {
            // Patró PRG amb missatge d'error
            return redirect()->route("posts.edit")
                ->with('error', __('ERROR Uploading file'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        // Eliminar post de BD
        $post->delete();
        // Eliminar fitxer associat del disc i BD
        $post->file->diskDelete();
        // Patró PRG amb missatge d'èxit
        return redirect()->route("posts.index")
            ->with('success', __('Post successfully deleted'));
    }

    /**
     * Confirm specified resource deletion from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function delete(Post $post)
    {
        return view("posts.delete", [
            'post' => $post
        ]);
    }
}
