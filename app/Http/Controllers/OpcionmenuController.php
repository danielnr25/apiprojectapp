<?php

namespace App\Http\Controllers;

use App\Models\OpcionMenu;
use Illuminate\Http\Request;

class OpcionMenuController extends Controller
{
    /**
     * Muestra una lista de todas las opciones de menú.
     */
    public function index()
    {
        $opciones = OpcionMenu::all();
        return response()->json(['message' => 'Listado de opciones de menú', 'data' => $opciones], 200);
    }

    /**
     * Almacena una nueva opción de menú en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'link' => 'nullable|string|max:255',
            'idopcion_menu_ref' => 'nullable|integer|exists:opcion_menus,idopcion_menu',
            'estado' => 'string|max:20'
        ]);

        try {
            $opcion = new OpcionMenu();
            $opcion->nombre = $request->nombre;
            $opcion->link = $request->link;
            $opcion->idopcion_menu_ref = $request->idopcion_menu_ref;
            $opcion->estado = 'ACTIVO';
            $opcion->save();

            return response()->json(['message' => 'Opción de menú creada', 'data' => $opcion], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al crear la opción de menú', 'error' => $e->getMessage()], 400);
        }
    }

    /**
     * Muestra una opción de menú específica.
     */
    public function show(string $id)
    {
        $opcion = OpcionMenu::find($id);

        if (!$opcion) {
            return response()->json(['message' => 'Opción de menú no encontrada'], 404);
        }

        return response()->json(['message' => 'Detalle de la opción de menú', 'data' => $opcion], 200);
    }

    /**
     * Actualiza una opción de menú existente.
     */
    public function update(Request $request, string $id)
    {
        $opcion = OpcionMenu::find($id);

        if (!$opcion) {
            return response()->json(['message' => 'Opción de menú no encontrada'], 404);
        }

        $request->validate([
            'nombre' => 'sometimes|required|string|max:50',
            'link' => 'sometimes|nullable|string|max:255',
            'idopcion_menu_ref' => 'sometimes|nullable|integer|exists:opcion_menus,idopcion_menu',
            'estado' => 'sometimes|string|max:20'
        ]);

        try {
            $opcion->update($request->all());
            return response()->json(['message' => 'Opción de menú actualizada', 'data' => $opcion], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al actualizar la opción de menú', 'error' => $e->getMessage()], 400);
        }
    }

    /**
     * Elimina una opción de menú de la base de datos.
     */
    public function destroy(string $id)
    {
        $opcion = OpcionMenu::find($id);

        if (!$opcion) {
            return response()->json(['message' => 'Opción de menú no encontrada'], 404);
        }

        try {
            $opcion->delete();
            return response()->json(['message' => 'Opción de menú eliminada'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al eliminar la opción de menú', 'error' => $e->getMessage()], 400);
        }
    }
}
