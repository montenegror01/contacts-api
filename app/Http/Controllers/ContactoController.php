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
        $search = $request->input('search'); // Obtén el parámetro de búsqueda
    $query = Contacto::with(['telefonos', 'emails', 'direcciones']);

    if ($search) {
        $query->where(function($q) use ($search) {
            $q->where('nombre', 'like', '%' . $search . '%')
              ->orWhereHas('telefonos', function ($q) use ($search) {
                  $q->where('numero', 'like', '%' . $search . '%');
              })
              ->orWhereHas('emails', function ($q) use ($search) {
                  $q->where('email', 'like', '%' . $search . '%');
              })
              ->orWhereHas('direcciones', function ($q) use ($search) {
                  $q->where('direccion', 'like', '%' . $search . '%');
              });
        });
    }

    return $query->paginate(10); // Mantén la paginación
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
        // Validar los datos
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'notas' => 'nullable|string',
            'fecha_nacimiento' => 'nullable|date',
            'pagina_web' => 'nullable|url',
            'empresa' => 'nullable|string|max:255',

            'telefonos' => 'required|array|min:1',  
            'telefonos.*.numero' => 'required|string|min:10|max:15',  
            'telefonos.*.tipo' => 'nullable|string',

            'emails' => 'required|array|min:1',  
            'emails.*.email' => 'required|email',

            'direcciones' => 'required|array|min:1',  
            'direcciones.*.direccion' => 'required|string',
            'direcciones.*.ciudad' => 'required|string',
            'direcciones.*.estado' => 'required|string',
            'direcciones.*.codigo_postal' => 'required|string',
        ]);

        // Crear el contacto principal
        $contacto = Contacto::create([
            'nombre' => $validated['nombre'],
            'notas' => $validated['notas'] ?? null,
            'fecha_nacimiento' => $validated['fecha_nacimiento'] ?? null,
            'pagina_web' => $validated['pagina_web'] ?? null,
            'empresa' => $validated['empresa'] ?? null,
        ]);

        // Agregar los teléfonos
        foreach ($validated['telefonos'] as $telefono) {
            $contacto->telefonos()->create([
                'numero' => $telefono['numero'],
                'tipo' => $telefono['tipo'] ?? null,
            ]);
        }

        // Agregar los emails
        foreach ($validated['emails'] as $email) {
            $contacto->emails()->create([
                'email' => $email['email'],
            ]);
        }

        // Agregar las direcciones
        foreach ($validated['direcciones'] as $direccion) {
            $contacto->direcciones()->create([
                'direccion' => $direccion['direccion'],
                'ciudad' => $direccion['ciudad'],
                'estado' => $direccion['estado'],
                'codigo_postal' => $direccion['codigo_postal'],
            ]);
        }

        return response()->json([
            'message' => 'Contacto creado exitosamente',
            'contacto' => $contacto->load(['telefonos', 'emails', 'direcciones'])  
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $contacto=Contacto::with(['telefonos', 'emails', 'direcciones'])->find($id);
        return response()->json($contacto);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validar los datos entrantes
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'notas' => 'nullable|string',
            'fecha_nacimiento' => 'nullable|date',
            'pagina_web' => 'nullable|url',
            'empresa' => 'nullable|string|max:255',
            'telefonos' => 'required|array',
            'telefonos.*.numero' => 'required|string|min:10|max:15',  
            'telefonos.*.tipo' => 'nullable|string',
            'emails' => 'required|array',
            'emails.*.email' => 'required|email',
            'direcciones' => 'required|array',
            'direcciones.*.direccion' => 'required|string',
            'direcciones.*.ciudad' => 'required|string',
            'direcciones.*.estado' => 'required|string',
            'direcciones.*.codigo_postal' => 'required|string',
        ]);
        // Encontrar el contacto
        $contacto = Contacto::with(['telefonos', 'emails', 'direcciones'])->findOrFail($id);

        // Actualizar los campos del contacto principal
        $contacto->update([
            'nombre' => $validated['nombre'],
            'notas' => $validated['notas'] ?? null,
            'fecha_nacimiento' => $validated['fecha_nacimiento'] ?? null,
            'pagina_web' => $validated['pagina_web'] ?? null,
            'empresa' => $validated['empresa'] ?? null,
        ]);

        // Actualizar los teléfonos
        $contacto->telefonos()->delete(); // Eliminar teléfonos anteriores
        foreach ($validated['telefonos'] as $telefono) {
            $contacto->telefonos()->create([
                'numero' => $telefono['numero'],
                'tipo' => $telefono['tipo'] ?? null
            ]);
        }

        // Actualizar los emails
        $contacto->emails()->delete();
        foreach ($validated['emails'] as $email) {
            $contacto->emails()->create(['email' => $email['email']]);
        }

        // Actualizar las direcciones
        $contacto->direcciones()->delete();
        foreach ($validated['direcciones'] as $direccion) {
            $contacto->direcciones()->create([
                'direccion' => $direccion['direccion'],
                'ciudad' => $direccion['ciudad'],
                'estado' => $direccion['estado'],
                'codigo_postal' => $direccion['codigo_postal'],
            ]);
        }

        return response()->json(['message' => 'Contacto actualizado correctamente', 'contacto' => $contacto]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $contacto = Contacto::with(['telefonos', 'emails', 'direcciones'])->findOrFail($id);

            // Eliminar las relaciones (telefonos, emails, direcciones)
            $contacto->telefonos()->delete();
            $contacto->emails()->delete();
            $contacto->direcciones()->delete();

            // Finalmente, eliminar el contacto
            $contacto->delete();

            return response()->json(['message' => 'Contacto eliminado exitosamente'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar el contacto', 'details' => $e->getMessage()], 500);
        }
    }
}
