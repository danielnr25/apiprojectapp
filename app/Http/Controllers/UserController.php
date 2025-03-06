<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = User::where('estado', 'ACTIVO')->get();
        return response()->json(['message' => 'Listado de usuarios', 'data' => $usuarios], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'usuario' => 'required|string|max:50|unique:users,usuario',
            'clave' => 'required|string|min:6',
            'idperfil' => 'required|integer'
        ]);

        try {
            $usuario = new User();
            $usuario->nombre = $request->nombre;
            $usuario->usuario = $request->usuario;
            $usuario->clave = Hash::make($request->clave);
            $usuario->idperfil = $request->idperfil;
            $usuario->estado = 'ACTIVO';
            $usuario->save();

            return response()->json(['message' => 'Usuario creado', 'data' => $usuario], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al crear el usuario', 'error' => $e->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $usuario = User::find($id);

        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        return response()->json(['message' => 'Detalle del usuario', 'data' => $usuario], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $usuario = User::find($id);

        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $request->validate([
            'nombre' => 'sometimes|required|string|max:100',
            'usuario' => 'sometimes|required|string|max:50|unique:users,usuario,' . $id,
            'clave' => 'sometimes|nullable|string|min:6',
            'idperfil' => 'sometimes|required|integer',
            'estado' => 'sometimes|required|string|max:20'
        ]);

        try {
            if ($request->has('clave')) {
                $request->merge(['clave' => Hash::make($request->clave)]);
            }
            $usuario->update($request->all());
            return response()->json(['message' => 'Usuario actualizado', 'data' => $usuario], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al actualizar el usuario', 'error' => $e->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $usuario = User::find($id);

        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        try {
            $usuario->delete();
            return response()->json(['message' => 'Usuario eliminado'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al eliminar el usuario', 'error' => $e->getMessage()], 400);
        }
    }

    public function autenticar(Request $request)
    {
        $request->validate([
            'Usuario' => 'required|string',
            'Clave' => 'required|string'
        ]);

        $usuario = User::where('usuario', $request->Usuario)->first();

        if (!$usuario || $request->Clave != $usuario->clave) {
            return response()->json(['message' => 'Credenciales incorrectas'], 401);
        }

        // Generar token : laravel sanctum
        $token = $usuario->createToken('api-token')->plainTextToken;

        // Permisos del usuario
        $perfil_id = $usuario->idperfil;
        $permisos = DB::table('permisos')
            ->join('opcion_menu', 'permisos.idopcionmenu', '=', 'opcion_menu.idopcion_menu')
            ->where('permisos.idperfil', $perfil_id)
            ->select(
                'opcion_menu.idopcion_menu',
                'opcion_menu.nombre as opcion_menu',
                'opcion_menu.link',
                'opcion_menu.idopcion_menu_ref'
            )
            ->get();

        return response()->json(['message' => 'Autenticación exitosa', 'data' => $usuario, 'permisos' => $permisos, 'token' => $token], 200);
    }
}
