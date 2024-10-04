<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactoController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rutas CRUD para contactos
Route::apiResource('contactos', ContactoController::class);

// Ruta adicional para filtrar contactos por ciudad
Route::get('contactos/ciudad/{ciudad}', [ContactoController::class, 'contactosPorCiudad']);