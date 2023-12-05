<?php

use App\Http\Controllers\Api\PacienteController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::get("/", function () {
    return response()->json([
        'sucess' => true
    ]);
});

Route::get('/pacientes/{id}', [PacienteController::class, "getOnePaciente"]);
Route::get("/pacientes", [PacienteController::class,"getAllPacientes"]);
Route::put("/pacientes/{id}", [PacienteController::class, "updatePaciente"]);
// Route::delete("/pacientes/{}")
Route::Post('/pacientes', [PacienteController::class,'createPaciente']);

