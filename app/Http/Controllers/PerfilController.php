<?php

namespace App\Http\Controllers;

use App\Models\Perfil;
use Illuminate\Http\Request;

class PerfilController extends Controller
{
    /**
     * Muestra una lista de todos los perfiles.
     */
    public function index()
    {
        $perfiles = Perfil::all();
        return response()->json(['message' => 'Listado de perfiles', 'data' => $perfiles], 200);
    }

    /**
     * Almacena un nuevo perfil en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'estado' => 'string|max:20'
        ]);

        try {
            $perfil = new Perfil();
            $perfil->nombre = $request->nombre;
            $perfil->estado = 'ACTIVO';
            $perfil->save();

            return response()->json(['message' => 'Perfil creado exitosamente', 'data' => $perfil], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al crear el perfil', 'error' => $e->getMessage()], 400);
        }
    }

    /**
     * Muestra un perfil específico.
     */
    public function show(string $id)
    {
        $perfil = Perfil::find($id);

        if (!$perfil) {
            return response()->json(['message' => 'Perfil no encontrado'], 404);
        }

        return response()->json(['message' => 'Detalle del perfil', 'data' => $perfil], 200);
    }

    /**
     * Actualiza un perfil existente.
     */
    public function update(Request $request, string $id)
    {
        $perfil = Perfil::find($id);

        if (!$perfil) {
            return response()->json(['message' => 'Perfil no encontrado'], 404);
        }

        $request->validate([
            'nombre' => 'sometimes|required|string|max:50',
            'estado' => 'sometimes|string|max:20'
        ]);

        try {
            $perfil->update($request->all());
            return response()->json(['message' => 'Perfil actualizado correctamente', 'data' => $perfil], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al actualizar el perfil', 'error' => $e->getMessage()], 400);
        }
    }

    /**
     * Elimina un perfil de la base de datos.
     */
    public function destroy(string $id)
    {
        $perfil = Perfil::find($id);

        if (!$perfil) {
            return response()->json(['message' => 'Perfil no encontrado'], 404);
        }

        try {
            $perfil->delete();
            return response()->json(['message' => 'Perfil eliminado correctamente'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al eliminar el perfil', 'error' => $e->getMessage()], 400);
        }
    }
}
