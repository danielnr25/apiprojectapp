<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\EstadoController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\TipoProyectoController;
use App\Http\Controllers\EtapaController;
use App\Http\Controllers\MiembroController;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rutas para el recurso TipoProyecto
Route::apiResource('tipo_proyectos', TipoProyectoController::class);
//api/tipo_proyectos -> GET
//api/tipo_proyectos -> POST
//api/tipo_proyectos/{id} -> GET (obtener un registro específico)
//api/tipo_proyectos/{id} -> PUT (actualizar un registro específico)
//api/tipo_proyectos/{id} -> DELETE (eliminar un registro específico)
Route::apiResource('proyectos', ProyectoController::class);
Route::apiResource('areas', AreaController::class);
Route::apiResource('usuarios', UserController::class);
Route::apiResource('etapas', EtapaController::class);
Route::apiResource('tareas', TareaController::class);
Route::apiResource('estados', EstadoController::class);
Route::apiResource('miembro', MiembroController::class);

Route::post('/autenticar', [UserController::class, 'autenticar']);
