<?php

use App\Http\Controllers\Api\PacienteController;
use App\Http\Controllers\Api\TagsController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::get("/", function () {
    return response()->json([
        'sucess' => true
    ]);
});

//Endpoints Pacientes
Route::get("/pacientes", [PacienteController::class,"getAllPacientes"]);
Route::get('/pacientes/{id}', [PacienteController::class, "getOnePaciente"]);
Route::put("/pacientes/{id}", [PacienteController::class, "updatePaciente"]);
Route::delete("/pacientes/{id}", [PacienteController::class,"deletePaciente"]);
Route::post('/pacientes', [PacienteController::class,'createPaciente']);

//Endpoints Tags
Route::get("/tags", [TagsController::class,"getAllTags"]);
Route::get("/tags/{id}", [TagsController::class, "getOneTags"]);
Route::get("/tags/codigo/{codigo}", [TagsController::class,"getWithCode"]);
Route::post("/tags", [TagsController::class, "createTags"]);
