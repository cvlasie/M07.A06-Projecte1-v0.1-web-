<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Post::class, 'post');
    }

    private bool $_pagination = true;

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function like(Request $request, Post $post)
    {
        $this->authorize('like', $post); // Utiliza la política para verificar el permiso

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
            'post'    => $post,
            'file'    => $post->file,
            'author'  => $post->user,
            'liked'   => $liked,
            'message' => $message,
        ]);
    }

    public function index(Request $request)
    {
        $collectionQuery = Post::withCount('likes')->orderBy('created_at', 'desc');

        // Filter?
        if ($search = $request->get('search')) {
            $collectionQuery->where('body', 'like', "%{$search}%");
        }

        // Pagination
        $posts = $this->_pagination
            ? $collectionQuery->paginate(5)->withQueryString()
            : $collectionQuery->get();

        return view("posts.index", [
            "posts"  => $posts,
            "search" => $search
        ]);
    }

    public function create()
    {
        return view("posts.create");
    }

    public function store(Request $request)
    {
        // Validar datos del formulario
        $validatedData = $request->validate([
            'body'      => 'required',
            'upload'    => 'required|mimes:gif,jpeg,jpg,png,mp4|max:2048',
            'latitude'  => 'required',
            'longitude' => 'required',
        ]);

        // Obtener datos del formulario
        $body      = $request->get('body');
        $upload    = $request->file('upload');
        $latitude  = $request->get('latitude');
        $longitude = $request->get('longitude');

        // Guardar archivo en el disco e insertar datos en BD
        $file = new File();
        $fileOk = $file->diskSave($upload);

        if ($fileOk) {
            // Guardar datos en BD
            Log::debug("Saving post at DB...");
            $post = Post::create([
                'body'      => $body,
                'file_id'   => $file->id,
                'latitude'  => $latitude,
                'longitude' => $longitude,
                'author_id' => auth()->user()->id,
            ]);
            Log::debug("DB storage OK");
            // Patrón PRG con mensaje de éxito
            return redirect()->route('posts.show', $post)
                ->with('success', __('Post successfully saved'));
        } else {
            // Patrón PRG con mensaje de error
            return redirect()->route("posts.create")
                ->with('error', __('ERROR Uploading file'));
        }
    }

    public function show(Post $post)
    {
        $post->loadCount('likes');

        // Obtener el usuario autenticado (si estás utilizando autenticación)
        $user = auth()->user();

        // Verificar si el usuario autenticado ha dado like al post
        $liked = $user ? $post->likes->contains($user->id) : false;

        return view("posts.show", [
            'post'   => $post,
            'file'   => $post->file,
            'author' => $post->user,
            'liked'  => $liked,
        ]);
    }

    public function edit(Post $post)
    {
        return view("posts.edit", [
            'post'   => $post,
            'file'   => $post->file,
            'author' => $post->user,
        ]);
    }

    public function update(Request $request, Post $post)
    {
        // Validar datos del formulario
        $validatedData = $request->validate([
            'body'      => 'required',
            'upload'    => 'nullable|mimes:gif,jpeg,jpg,png,mp4|max:2048',
            'latitude'  => 'required',
            'longitude' => 'required',
        ]);

        // Obtener datos del formulario
        $body      = $request->get('body');
        $upload    = $request->file('upload');
        $latitude  = $request->get('latitude');
        $longitude = $request->get('longitude');

        // Guardar archivo (opcional)
        if (is_null($upload) || $post->file->diskSave($upload)) {
            // Actualizar datos en BD
            Log::debug("Updating DB...");
            $post->body      = $body;
            $post->latitude  = $latitude;
            $post->longitude = $longitude;
            $post->save();
            Log::debug("DB storage OK");
            // Patrón PRG con mensaje de éxito
            return redirect()->route('posts.show', $post)
                ->with('success', __('Post successfully saved'));
        } else {
            // Patrón PRG con mensaje de error
            return redirect()->route("posts.edit")
                ->with('error', __('ERROR Uploading file'));
        }
    }

    public function destroy(Post $post)
    {
        // Eliminar post de BD
        $post->delete();
        // Eliminar archivo asociado del disco y BD
        $post->file->diskDelete();
        // Patrón PRG con mensaje de éxito
        return redirect()->route("posts.index")
            ->with('success', __('Post successfully deleted'));
    }

    public function delete(Post $post)
    {
        return view("posts.delete", [
            'post' => $post
        ]);
    }
}