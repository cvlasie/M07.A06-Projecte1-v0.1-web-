<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Visibility;

class PlaceController extends Controller
{
    private bool $_pagination = true;

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $collectionQuery = Place::orderBy('created_date', 'desc');

        // Filter?
        if ($search = $request->get('search')) {
            $collectionQuery->where('description', 'like', "%{$search}%");
        }
        
        // Pagination
        $places = $this->_pagination 
            ? $collectionQuery->paginate(5)->withQueryString() 
            : $collectionQuery->get();
        
        return view("places.index", [
            "places" => $places,
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
        $visibilities = Visibility::all();

        return view('places.create', [
        'visibilities' => $visibilities,
        ]);
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
            'name'        => 'required',
            'description' => 'required',
            'upload'      => 'required|mimes:gif,jpeg,jpg,png,mp4|max:2048',
            'latitude'    => 'required',
            'longitude'   => 'required',
            'visibility_id' => 'required|exists:visibilities,id',
        ]);
        
        // Obtenir dades del formulari
        $name        = $request->get('name');
        $description = $request->get('description');
        $upload      = $request->file('upload');
        $latitude    = $request->get('latitude');
        $longitude   = $request->get('longitude');

        // Desar fitxer al disc i inserir dades a BD
        $file = new File();
        $fileOk = $file->diskSave($upload);

        if ($fileOk) {
            // Desar dades a BD
            Log::debug("Saving place at DB...");
            $place = Place::create([
                'name'        => $name,
                'description' => $description,
                'file_id'     => $file->id,
                'latitude'    => $latitude,
                'longitude'   => $longitude,
                'author_id'   => auth()->user()->id,
                'visibility_id' => $request->get('visibility_id'),
            ]);
            \Log::debug("DB storage OK");
            // Patró PRG amb missatge d'èxit
            return redirect()->route('places.show', $place)
                ->with('success', __('Place successfully saved'));
        } else {
            \Log::debug("Disk storage FAILS");
            // Patró PRG amb missatge d'error
            return redirect()->route("places.create")
                ->with('error', __('ERROR Uploading file'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function show(Place $place)
    {
        // Carregar la relació 'visibility' si no està ja carregada
        if (!$place->relationLoaded('visibility')) {
            $place->load('visibility');
        }

        $isFavorited = auth()->user() ? $place->favorited->contains(auth()->user()->id) : false;
        $favoritesCount = $place->favorited->count();

        // Assegura't que l'objecte 'user' (autor) estigui carregat
        $author = $place->user ?? null; // Retorna null si 'user' no està definit

        return view("places.show", [
            'place'          => $place,
            'file'           => $place->file,
            'author'         => $author,
            'isFavorited'    => $isFavorited,
            'favoritesCount' => $favoritesCount,
        ]);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function edit(Place $place)
    {
        $this->authorize('update', $place);

        // Obtenir totes les visibilitats
        $visibilities = Visibility::all();

        return view("places.edit", [
            'place'       => $place,
            'file'        => $place->file,
            'author'      => $place->user,
            'visibilities' => $visibilities, // Afegir aquesta línia
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Place $place)
    {
        // Validar dades del formulari
        $validatedData = $request->validate([
            'name'        => 'required',
            'description' => 'required',
            'upload'      => 'nullable|mimes:gif,jpeg,jpg,png,mp4|max:2048',
            'latitude'    => 'required',
            'longitude'   => 'required',
            'visibility_id' => 'required|exists:visibilities,id',
        ]);
        
        // Obtenir dades del formulari
        $name        = $request->get('name');
        $description = $request->get('description');
        $upload      = $request->file('upload');
        $latitude    = $request->get('latitude');
        $longitude   = $request->get('longitude');
        $visibilityId = $request->get('visibility_id');

        // Desar fitxer (opcional)
        if (is_null($upload) || $place->file->diskSave($upload)) {
            // Actualitzar dades a BD
            Log::debug("Updating DB...");
            $place->name        = $name;
            $place->description = $description;
            $place->latitude    = $latitude;
            $place->longitude   = $longitude;
            $place->visibility_id = $visibilityId;
            $place->save();
            \Log::debug("DB storage OK");
            // Patró PRG amb missatge d'èxit
            return redirect()->route('places.show', $place)
                ->with('success', __('Place successfully saved'));
        } else {
            // Patró PRG amb missatge d'error
            return redirect()->route("places.create")
                ->with('error', __('ERROR Uploading file'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function destroy(Place $place)
    {
        // Eliminar place de BD
        $place->delete();
        // Eliminar fitxer associat del disc i BD
        $place->file->diskDelete();
        // Patró PRG amb missatge d'èxit
        return redirect()->route("places.index")
            ->with('success', __('Place successfully deleted'));
    }

    /**
     * Confirm specified resource deletion from storage.
     *
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function delete(Place $place)
    {
        return view("places.delete", [
            'place' => $place
        ]);
    }

    public function favorite(Place $place)
    {
        // Afegir un 'favorite' al place actual per l'usuari autenticat
        $place->favorited()->attach(auth()->user()->id);
        
        // Lògica per afegir un 'favorite'
        return redirect()->back()->with('success', __('Place added to favorites'));
    }

    public function unfavorite(Place $place)
    {
        // Eliminar el 'favorite' del place actual per l'usuari autenticat
        $place->favorited()->detach(auth()->user()->id);

        // Lògica per eliminar un 'favorite'
        return redirect()->back()->with('success', __('Place removed from favorites'));
    }

    public function __construct()
    {
        $this->authorizeResource(Place::class, 'place');
    }

}
