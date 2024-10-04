<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contacto;

class ContactoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contactos = Contacto::with(['telefonos', 'emails', 'direcciones'])->paginate(10);
        return response()->json($contactos);
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
        $request->validate([
            'nombre' => 'required|string|max:255',
            'telefonos.*.numero' => 'required|string',
            'emails.*.email' => 'required|email',
        ]);
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
