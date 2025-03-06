<?php

namespace App\Http\Controllers;

use App\Models\TipoProyecto;
use Illuminate\Http\Request;

class TipoProyectoController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    //Mostrar todos los registros de la tabla tipo_proyecto
    public function index()
    {
        // Método GET: api/tipo_proyectos, nos permite obtener un listado de todos los tipos de proyecto
        $tipo_proyecto = TipoProyecto::where('estado','ACTIVO')->get(); // SELECT * FROM tipo_proyecto WHERE estado = 'ACTIVO'
        $response = [
            'message' => 'Listado de tipos de proyecto',
            'data' => $tipo_proyecto
        ];

        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    // Almacenar un nuevo registro en la tabla tipo_proyecto
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'comentario' => 'nullable|string'
        ]);

        try {
            //$tipoProyecto = TipoProyecto::create($request->all());
            // Método POST: api/tipo_proyectos, nos permite almacenar un nuevo tipo de proyecto
            $tipo_proyecto = new TipoProyecto();
            $tipo_proyecto->nombre = $request->nombre; // $request->nombre = 'nombre del tipo de proyecto'
            $tipo_proyecto->comentario = $request->comentario;
            $tipo_proyecto->estado = 'ACTIVO';
            $tipo_proyecto->save(); // INSERT INTO tipo_proyecto (nombre, comentario, estado) VALUES ($request->nombre, $request->comentario, 'ACTIVO')

            $response = [
                'message' => 'Tipo de proyecto creado',
                'data' => $tipo_proyecto
            ];

            return response()->json($response, 201);

        } catch (\Exception $e) {
            $response = [
                'message' => 'Error al crear el tipo de proyecto',
                'data' => null,
                'error' => $e->getMessage()
            ];
            return response()->json($response, 400);
        }
    }

    /**
     * Display the specified resource.
     */

     // Mostrar un registro específico de la tabla tipo_proyecto
    public function show(string $id)
    {
        // Método GET: api/tipo_proyectos/id, nos permite obtener un registro específico de un tipo de proyecto

        if($id == null){
            $response = [
                'message' => 'No se ha especificado un tipo de proyecto',
                'data' => null
            ];
            return response()->json($response, 400);
        }else{
            $tipo_proyecto = TipoProyecto::find($id); // SELECT * FROM tipo_proyecto WHERE idtipo_proyecto = $id
            $response = [
                'message' => 'Tipo de proyecto encontrado',
                'data' => $tipo_proyecto
            ];
            return response()->json($response, 200);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    // Actualizar un registro específico de la tabla tipo_proyecto
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'comentario' => 'nullable|string',
            'estado' => 'required'
        ]);

        try {
            // Método PUT: api/tipo_proyectos/id, nos permite actualizar un registro específico de un tipo de proyecto

            $tipo_proyecto = TipoProyecto::find($id); // SELECT * FROM tipo_proyecto WHERE idtipo_proyecto = $id

            if($tipo_proyecto == null){
                $response = [
                    'message' => 'Tipo de proyecto no encontrado',
                    'data' => null
                ];
                return response()->json($response, 404);
            }else{
                $tipo_proyecto->nombre = $request->nombre; // $request->nombre = 'nombre del tipo de proyecto'
                $tipo_proyecto->comentario = $request->comentario;
                $tipo_proyecto->estado = $request->estado;
                $tipo_proyecto->save(); // UPDATE tipo_proyecto SET nombre = $request->nombre, comentario = $request->comentario WHERE idtipo_proyecto = $id

                $response = [
                    'message' => 'Tipo de proyecto actualizado',
                    'data' => $tipo_proyecto
                ];

                return response()->json($response, 200);
            }
        } catch (\Exception $e) {
            $response = [
                'message' => 'Error al actualizar el tipo de proyecto',
                'data' => null,
                'error' => $e->getMessage()
            ];
            return response()->json($response, 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    // Eliminar un registro específico de la tabla tipo_proyecto
    public function destroy(string $id)
    {
        $tipo_proyecto = TipoProyecto::find($id); // SELECT * FROM tipo_proyecto WHERE idtipo_proyecto = $id

        if(!$tipo_proyecto){
            $response = [
                'message' => 'Tipo de proyecto no encontrado',
                'data' => null
            ];
            return response()->json($response, 404);
        }else{
            $tipo_proyecto->estado = 'INACTIVO';
            $tipo_proyecto->save(); // UPDATE tipo_proyecto SET estado = 'INACTIVO' WHERE idtipo_proyecto = $id

            $response = [
                'message' => 'Tipo de proyecto eliminado',
                'data' => $tipo_proyecto
            ];

             return response()->json($response, 200);
            // $tipo_proyecto->delete(); // DELETE FROM tipo_proyecto WHERE idtipo_proyecto = $id
            // $response = [
            //     'message' => 'Tipo de proyecto eliminado',
            //     'data' => $tipo_proyecto
            // ];
        }
    }
}
