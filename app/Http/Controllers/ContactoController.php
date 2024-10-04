<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contacto;

class ContactoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Contacto::with(['telefonos', 'emails', 'direcciones']);

    if ($request->has('ciudad')) {
        $query->whereHas('direcciones', function($q) use ($request) {
            $q->where('ciudad', $request->ciudad);
        });
    }

    return $query->paginate(10);
    }

    public function contactosPorCiudad($ciudad)
    {
        $contactos = Contacto::whereHas('direcciones', function ($query) use ($ciudad) {
            $query->where('ciudad', $ciudad);
        })->get();

        return response()->json($contactos);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'notas' => 'nullable|string',
            'fecha_nacimiento' => 'nullable|date',
            'pagina_web' => 'nullable|url',
            'empresa' => 'nullable|string|max:255',
            'telefonos' => 'required|array',
            'telefonos.*' => 'required|string|min:10|max:15',
            'emails' => 'required|array',
            'emails.*' => 'required|email',
            'direcciones' => 'required|array',
            'direcciones.*.direccion' => 'required|string',
            'direcciones.*.ciudad' => 'required|string',
        ]);
        $contacto = Contacto::create($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'telefonos.*.numero' => 'required|string',
            'emails.*.email' => 'required|email',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
