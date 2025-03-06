<?php

namespace App\Http\Controllers;

use App\Models\Miembro;
use Illuminate\Http\Request;

class MiembroController extends Controller
{
    /**
     * Muestra una lista de los miembros activos.
     */
    public function index()
    {
        $miembros = Miembro::where('estado', 'ACTIVO')->get();
        return response()->json(['message' => 'Listado de miembros', 'data' => $miembros], 200);
    }

    /**
     * Almacena un nuevo miembro en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'comentario' => 'nullable|string',
            'idproyecto' => 'required|integer',
            'idusuario' => 'nullable|integer'
        ]);

        try {
            $miembro = new Miembro();
            $miembro->nombre = $request->nombre;
            $miembro->comentario = $request->comentario;
            $miembro->idproyecto = $request->idproyecto;
            $miembro->idusuario = $request->idusuario;
            $miembro->estado = 'ACTIVO';
            $miembro->save();

            return response()->json(['message' => 'Miembro creado', 'data' => $miembro], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al crear el miembro', 'error' => $e->getMessage()], 400);
        }
    }

    /**
     * Muestra un miembro específico.
     */
    public function show(string $id)
    {
        $miembro = Miembro::find($id);

        if (!$miembro) {
            return response()->json(['message' => 'Miembro no encontrado'], 404);
        }

        return response()->json(['message' => 'Detalle del miembro', 'data' => $miembro], 200);
    }

    /**
     * Actualiza un miembro existente.
     */
    public function update(Request $request, string $id)
    {
        $miembro = Miembro::find($id);

        if (!$miembro) {
            return response()->json(['message' => 'Miembro no encontrado'], 404);
        }

        $request->validate([
            'nombre' => 'sometimes|required|string|max:100',
            'comentario' => 'sometimes|nullable|string',
            'idproyecto' => 'sometimes|required|integer',
            'idusuario' => 'sometimes|nullable|integer',
            'estado' => 'sometimes|required|string|max:20'
        ]);

        try {
            $miembro->update($request->all());
            return response()->json(['message' => 'Miembro actualizado', 'data' => $miembro], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al actualizar el miembro', 'error' => $e->getMessage()], 400);
        }
    }

    /**
     * Elimina un miembro de la base de datos.
     */
    public function destroy(string $id)
    {
        $miembro = Miembro::find($id);

        if (!$miembro) {
            return response()->json(['message' => 'Miembro no encontrado'], 404);
        }

        try {
            $miembro->delete();
            return response()->json(['message' => 'Miembro eliminado'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al eliminar el miembro', 'error' => $e->getMessage()], 400);
        }
    }
}
