<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use Illuminate\Http\Request;

class EstadoController extends Controller
{
    /**
     * Muestra una lista de los estados activos.
     */
    public function index()
    {
        $estados = Estado::where('estado', 'ACTIVO')->get();
        return response()->json(['message' => 'Listado de estados', 'data' => $estados], 200);
    }

    /**
     * Almacena un nuevo estado en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'comentario' => 'nullable|string',
            'maximo_tareas' => 'nullable|integer',
            'idproyecto' => 'required|integer'
        ]);

        try {
            $estado = new Estado();
            $estado->nombre = $request->nombre;
            $estado->comentario = $request->comentario;
            $estado->maximo_tareas = $request->maximo_tareas;
            $estado->idproyecto = $request->idproyecto;
            $estado->estado = 'ACTIVO';
            $estado->save();

            return response()->json(['message' => 'Estado creado', 'data' => $estado], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al crear el estado', 'error' => $e->getMessage()], 400);
        }
    }

    /**
     * Muestra un estado específico.
     */
    public function show(string $id)
    {
        $estado = Estado::find($id);

        if (!$estado) {
            return response()->json(['message' => 'Estado no encontrado'], 404);
        }

        return response()->json(['message' => 'Detalle del estado', 'data' => $estado], 200);
    }

    /**
     * Actualiza un estado existente.
     */
    public function update(Request $request, string $id)
    {
        $estado = Estado::find($id);

        if (!$estado) {
            return response()->json(['message' => 'Estado no encontrado'], 404);
        }

        $request->validate([
            'nombre' => 'sometimes|required|string|max:100',
            'comentario' => 'sometimes|nullable|string',
            'maximo_tareas' => 'sometimes|nullable|integer',
            'idproyecto' => 'sometimes|required|integer',
            'estado' => 'sometimes|required|string|max:20'
        ]);

        try {
            $estado->update($request->all());
            return response()->json(['message' => 'Estado actualizado', 'data' => $estado], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al actualizar el estado', 'error' => $e->getMessage()], 400);
        }
    }

    /**
     * Elimina un estado de la base de datos.
     */
    public function destroy(string $id)
    {
        $estado = Estado::find($id);

        if (!$estado) {
            return response()->json(['message' => 'Estado no encontrado'], 404);
        }

        try {
            $estado->delete();
            return response()->json(['message' => 'Estado eliminado'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al eliminar el estado', 'error' => $e->getMessage()], 400);
        }
    }
}
