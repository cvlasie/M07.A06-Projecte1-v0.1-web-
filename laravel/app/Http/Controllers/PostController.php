<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Muestra una lista de todos los posts.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::paginate(5); 
        return view('posts.index', compact('posts'));
    }
    

    /**
     * Muestra el formulario para crear un nuevo post.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Almacena un nuevo post en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validación de la imagen
        ]);

        $post = new Post();
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->user_id = auth()->user()->id; // Asigna el ID del usuario actual

        // Procesa la imagen si se cargó
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName);
            $post->image = $imageName;
        }


        $post->save();

        return redirect()->route('posts.index');
    }

    /**
     * Muestra un post específico y sus comentarios.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
    
        if (!$post) {
            return redirect()->route('posts.index')->with('error', 'El post no se encontró');
        }
    
        $likesCount = $post->likes; // Obtener el número de likes desde el modelo Post
        return view('posts.show', compact('post', 'likesCount'));
    }

    /**
     * Agrega un like al post.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function like($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return redirect()->route('posts.index')->with('error', 'El post no se encontró');
        }

        $post->likes++; // Incrementa el contador de likes
        $post->save();

        return redirect()->back()->with('success', 'Le diste like a este post');
    }

    /**
     * Almacena un nuevo comentario en el post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function comment(Request $request, $id)
    {
        $request->validate([
            'content' => 'required',
        ]);
    
        $post = Post::find($id);
    
        if (!$post) {
            return redirect()->route('posts.index')->with('error', 'El post no se encontró');
        }
    
        // Lógica para almacenar el comentario en el post
        $comment = new Comment();
        $comment->content = $request->input('content');
        $comment->user_id = auth()->user()->id;
        $post->comments()->save($comment);
    
        return redirect()->back()->with('success', 'Comentario agregado correctamente');
    }
    public function edit($id)
    {
        $post = Post::find($id);
        // Realiza cualquier lógica necesaria para editar el post
        return view('posts.edit', compact('post'));
    }
    public function update(Request $request, $id)
    {
        $post = Post::find($id);
    
        if (!$post) {
            return redirect()->route('posts.index')->with('error', 'El post no se encontró');
        }
    
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Asegúrate de que acepta tipos de imagen válidos y un tamaño máximo
        ]);
    
        $post->title = $request->input('title');
        $post->content = $request->input('content');
    
        // Procesa la nueva imagen si se proporciona
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName);
    
            // Si había una imagen anterior, elimínala
            if ($post->image) {
                Storage::disk('public')->delete('images/' . $post->image);
            }
    
            $post->image = $imageName;
        }
    
        $post->save();
    
        return redirect()->route('posts.show', $post->id)->with('success', 'El post se actualizó correctamente');
    }
    public function search(Request $request)
    {
        $query = $request->input('query');

        // Realiza una consulta para buscar posts que coincidan con la consulta
        $posts = Post::where('title', 'like', "%$query%")
                    ->orWhere('content', 'like', "%$query%")
                    ->get();

        return view('posts.index', compact('posts'));
    }
}