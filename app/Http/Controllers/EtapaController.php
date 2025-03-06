<?php

namespace App\Http\Controllers;

use App\Models\Etapa;
use Illuminate\Http\Request;

class EtapaController extends Controller
{
    /**
     * Muestra una lista de las etapas activas.
     */
    public function index()
    {
        $etapas = Etapa::where('estado', 'ACTIVO')->get();
        return response()->json(['message' => 'Listado de etapas', 'data' => $etapas], 200);
    }

    /**
     * Almacena una nueva etapa en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'comentario' => 'nullable|string',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date',
            'idproyecto' => 'required|integer',
            'idusuario' => 'nullable|integer'
        ]);

        try {
            $etapa = new Etapa();
            $etapa->nombre = $request->nombre;
            $etapa->comentario = $request->comentario;
            $etapa->fecha_inicio = $request->fecha_inicio;
            $etapa->fecha_fin = $request->fecha_fin;
            $etapa->idproyecto = $request->idproyecto;
            $etapa->idusuario = $request->idusuario;
            $etapa->estado = 'ACTIVO';
            $etapa->save();

            return response()->json(['message' => 'Etapa creada', 'data' => $etapa], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al crear la etapa', 'error' => $e->getMessage()], 400);
        }
    }

    /**
     * Muestra una etapa específica.
     */
    public function show(string $id)
    {
        $etapa = Etapa::find($id);

        if (!$etapa) {
            return response()->json(['message' => 'Etapa no encontrada'], 404);
        }

        return response()->json(['message' => 'Detalle de la etapa', 'data' => $etapa], 200);
    }

    /**
     * Actualiza una etapa existente.
     */
    public function update(Request $request, string $id)
    {
        $etapa = Etapa::find($id);

        if (!$etapa) {
            return response()->json(['message' => 'Etapa no encontrada'], 404);
        }

        $request->validate([
            'nombre' => 'sometimes|required|string|max:100',
            'comentario' => 'sometimes|nullable|string',
            'fecha_inicio' => 'sometimes|nullable|date',
            'fecha_fin' => 'sometimes|nullable|date',
            'idproyecto' => 'sometimes|required|integer',
            'idusuario' => 'sometimes|nullable|integer',
            'estado' => 'sometimes|required|string|max:20'
        ]);

        try {
            $etapa->update($request->all());
            return response()->json(['message' => 'Etapa actualizada', 'data' => $etapa], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al actualizar la etapa', 'error' => $e->getMessage()], 400);
        }
    }

    /**
     * Elimina una etapa de la base de datos.
     */
    public function destroy(string $id)
    {
        $etapa = Etapa::find($id);

        if (!$etapa) {
            return response()->json(['message' => 'Etapa no encontrada'], 404);
        }

        try {
            $etapa->delete();
            return response()->json(['message' => 'Etapa eliminada'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al eliminar la etapa', 'error' => $e->getMessage()], 400);
        }
    }
}
