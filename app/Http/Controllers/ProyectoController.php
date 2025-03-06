<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use Illuminate\Http\Request;

class ProyectoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proyecto = Proyecto::where('estado', 'ACTIVO')->get();
        $response = [
            'message' => 'Listado de proyectos',
            'data' => $proyecto
        ];

        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'idtipo_proyecto' => 'required|integer',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'detalle' => 'nullable|string',
            'idusuario' => 'required|integer'
        ]);

        try {
            $proyecto = new Proyecto();
            $proyecto->nombre = $request->nombre;
            $proyecto->idtipo_proyecto = $request->idtipo_proyecto;
            $proyecto->fecha_inicio = $request->fecha_inicio;
            $proyecto->fecha_fin = $request->fecha_fin;
            $proyecto->detalle = $request->detalle;
            $proyecto->estado = 'ACTIVO';
            $proyecto->idusuario = $request->idusuario;
            $proyecto->save();

            $response = [
                'message' => 'Proyecto creado',
                'data' => $proyecto
            ];

            return response()->json($response, 201);

        } catch (\Exception $e) {
            $response = [
                'message' => 'Error al crear el proyecto',
                'data' => null,
                'error' => $e->getMessage()
            ];
            return response()->json($response, 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $proyecto = Proyecto::find($id);

        if (!$proyecto) {
            return response()->json(['message' => 'Proyecto no encontrado'], 404);
        }

        return response()->json(['message' => 'Detalle del proyecto', 'data' => $proyecto], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $proyecto = Proyecto::find($id);

        if (!$proyecto) {
            return response()->json(['message' => 'Proyecto no encontrado'], 404);
        }

        $request->validate([
            'nombre' => 'sometimes|required|string|max:100',
            'idtipo_proyecto' => 'sometimes|required|integer',
            'fecha_inicio' => 'sometimes|required|date',
            'fecha_fin' => 'sometimes|required|date',
            'detalle' => 'nullable|string',
            'estado' => 'sometimes|required|string|max:20',
            'idusuario' => 'sometimes|required|integer'
        ]);

        try {
            $proyecto->update($request->all());
            return response()->json(['message' => 'Proyecto actualizado', 'data' => $proyecto], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al actualizar el proyecto', 'error' => $e->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $proyecto = Proyecto::find($id);

        if (!$proyecto) {
            return response()->json(['message' => 'Proyecto no encontrado'], 404);
        }

        try {
            $proyecto->delete();
            return response()->json(['message' => 'Proyecto eliminado'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al eliminar el proyecto', 'error' => $e->getMessage()], 400);
        }
    }
}
