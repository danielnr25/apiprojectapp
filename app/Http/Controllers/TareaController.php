<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use Illuminate\Http\Request;

class TareaController extends Controller
{
    /**
     * Muestra una lista de todas las tareas.
     */
    public function index()
    {
        $tareas = Tarea::all();
        return response()->json(['message' => 'Listado de tareas', 'data' => $tareas], 200);
    }

    /**
     * Almacena una nueva tarea en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'comentario' => 'nullable|string',
            'idproyecto' => 'required|integer',
            'idetapa' => 'required|integer',
            'idarea' => 'required|integer',
            'idmiembro' => 'required|integer'
        ]);

        try {
            $tarea = new Tarea();
            $tarea->nombre = $request->nombre;
            $tarea->comentario = $request->comentario;
            $tarea->idproyecto = $request->idproyecto;
            $tarea->idetapa = $request->idetapa;
            $tarea->idarea = $request->idarea;
            $tarea->idmiembro = $request->idmiembro;
            $tarea->save();

            return response()->json(['message' => 'Tarea creada', 'data' => $tarea], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al crear la tarea', 'error' => $e->getMessage()], 400);
        }
    }

    /**
     * Muestra una tarea específica.
     */
    public function show(string $id)
    {
        $tarea = Tarea::find($id);

        if (!$tarea) {
            return response()->json(['message' => 'Tarea no encontrada'], 404);
        }

        return response()->json(['message' => 'Detalle de la tarea', 'data' => $tarea], 200);
    }

    /**
     * Actualiza una tarea existente.
     */
    public function update(Request $request, string $id)
    {
        $tarea = Tarea::find($id);

        if (!$tarea) {
            return response()->json(['message' => 'Tarea no encontrada'], 404);
        }

        $request->validate([
            'nombre' => 'sometimes|required|string|max:100',
            'comentario' => 'sometimes|nullable|string',
            'idproyecto' => 'sometimes|required|integer',
            'idetapa' => 'sometimes|required|integer',
            'idarea' => 'sometimes|required|integer',
            'idmiembro' => 'sometimes|required|integer'
        ]);

        try {
            $tarea->update($request->all());
            return response()->json(['message' => 'Tarea actualizada', 'data' => $tarea], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al actualizar la tarea', 'error' => $e->getMessage()], 400);
        }
    }

    /**
     * Elimina una tarea de la base de datos.
     */
    public function destroy(string $id)
    {
        $tarea = Tarea::find($id);

        if (!$tarea) {
            return response()->json(['message' => 'Tarea no encontrada'], 404);
        }

        try {
            $tarea->delete();
            return response()->json(['message' => 'Tarea eliminada'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al eliminar la tarea', 'error' => $e->getMessage()], 400);
        }
    }
}
