<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Place; // Asegúrate de que el modelo Place existe
use Illuminate\Support\Facades\Storage;

class PlacesController extends Controller
{
    /**
     * Muestra una lista de todos los lugares.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $places = Place::all();
        return view('places.index', compact('places'));
    }

    /**
     * Muestra el formulario para crear un nuevo lugar.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('places.create');
    }

    /**
     * Almacena un nuevo lugar en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|max:255',
            // Añadir otras validaciones necesarias
            'media' => 'required|file|max:10240', // Ejemplo de validación de archivo
        ]);

        // Procesar y guardar el archivo en el storage
        if ($request->hasFile('media')) {
            $mediaFile = $request->file('media');
            $mediaName = time() . '.' . $mediaFile->getClientOriginalExtension();
            $path = $mediaFile->storeAs('public/media', $mediaName);

            // Crear el registro en la tabla 'files'
            $file = new File();
            $file->filepath = $path; // Guardar la ruta del archivo
            $file->filesize = $mediaFile->getSize(); // Guardar el tamaño del archivo
            $file->save();
        }

        // Obtener todas las entradas del formulario
        $input = $request->all();

        // Crear un nuevo registro en 'places' con las entradas del formulario y la clave foránea
        $place = new Place();
        $place->fill($input);
        $place->file_id = $file->id; // Asignar el ID del archivo a la propiedad file_id
        $place->author_id = Auth::id(); // Asignar el ID del usuario autenticado a la propiedad author_id
        $place->save();

        // Redireccionar con un mensaje de éxito
        return redirect()->route('places.index')->with('success', 'Lugar creado correctamente');
    }
   

    /**
     * Muestra un lugar específico.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $place = Place::find($id);
        return view('places.show', compact('place'));
    }

    /**
     * Muestra el formulario para editar un lugar específico.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $place = Place::find($id);
        return view('places.edit', compact('place'));
    }

    /**
     * Actualiza un lugar específico en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $place = Place::find($id);

        // Agrega las mismas validaciones o las necesarias para actualizar
        $request->validate([
            'name' => 'required|max:255',
            // Agrega otras validaciones necesarias aquí
            'media' => 'file|max:10240', // Permite archivos multimedia opcionales
        ]);

        $place->name = $request->input('name');
        // Actualiza el resto de campos aquí

        // Procesa el nuevo archivo multimedia si se proporciona
        if ($request->hasFile('media')) {
            $media = $request->file('media');
            $mediaName = time() . '.' . $media->getClientOriginalExtension();
            $media->storeAs('public/media', $mediaName);

            // Si había un archivo multimedia anterior, elimínalo
            if ($place->media) {
                Storage::disk('public')->delete('media/' . $place->media);
            }

            $place->media = $mediaName;
        }

        $place->save();

        return redirect()->route('places.show', $place->id)->with('success', 'Lugar actualizado correctamente');
    }

    /**
    * Elimina un lugar específico de la base de datos.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        $place = Place::find($id);

        // Si no se encuentra el lugar, redirigir con un mensaje de error
        if (!$place) {
            return redirect()->route('places.index')->with('error', 'El lugar no se encontró');
        }

        // Si había un archivo multimedia, elimínalo
        if ($place->media) {
            Storage::disk('public')->delete('media/' . $place->media);
        }

        // Elimina el lugar de la base de datos
        $place->delete();

        return redirect()->route('places.index')->with('success', 'Lugar eliminado correctamente');
    }
}
