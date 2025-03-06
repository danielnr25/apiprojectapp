<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $areas = Area::where('estado', 'ACTIVO')->get();
        return response()->json(['message' => 'Listado de áreas', 'data' => $areas], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'comentario' => 'nullable|string',
            'idproyecto' => 'required|integer'
        ]);

        try {
            $area = new Area();
            $area->nombre = $request->nombre;
            $area->comentario = $request->comentario;
            $area->idproyecto = $request->idproyecto;
            $area->estado = 'ACTIVO';
            $area->save();

            return response()->json(['message' => 'Área creada', 'data' => $area], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al crear el área', 'error' => $e->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $area = Area::find($id);

        if (!$area) {
            return response()->json(['message' => 'Área no encontrada'], 404);
        }

        return response()->json(['message' => 'Detalle del área', 'data' => $area], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $area = Area::find($id);

        if (!$area) {
            return response()->json(['message' => 'Área no encontrada'], 404);
        }

        $request->validate([
            'nombre' => 'sometimes|required|string|max:100',
            'comentario' => 'sometimes|nullable|string',
            'idproyecto' => 'sometimes|required|integer',
            'estado' => 'sometimes|required|string|max:20'
        ]);

        try {
            $area->update($request->all());
            return response()->json(['message' => 'Área actualizada', 'data' => $area], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al actualizar el área', 'error' => $e->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $area = Area::find($id);

        if (!$area) {
            return response()->json(['message' => 'Área no encontrada'], 404);
        }

        try {
            $area->delete();
            return response()->json(['message' => 'Área eliminada'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al eliminar el área', 'error' => $e->getMessage()], 400);
        }
    }
}
