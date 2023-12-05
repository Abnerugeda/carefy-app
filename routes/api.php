<?php

use App\Http\Controllers\Api\PacienteController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::get("/pacientes", [PacienteController::class,"getAllPacientes"]);
Route::get("/", function () {
    return response()->json([
        'sucess' => true
    ]);
});
Route::get("/hello", function () { 
    return response()->json([
        "code" => 200,
        "message" => 'Hello world'
    ]);
});

Route::Post('/pacientes', [PacienteController::class,'createPaciente']);
