<?php

use App\Http\Controllers\Api\PacienteController;
use App\Http\Controllers\Api\TagsController;
use App\Http\Controllers\Api\TagsPacienteController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::get("/", function () {
    return response()->json([
        'sucess' => true
    ]);
});

//Endpoints Pacientes
Route::get("/pacientes", [PacienteController::class,"getAllPacientes"]);
Route::get('/pacientes/{codigo}', [PacienteController::class, "getOnePaciente"]);
Route::put("/pacientes/{codigo}", [PacienteController::class, "updatePaciente"]);
Route::delete("/pacientes/{codigo}", [PacienteController::class,"deletePaciente"]);
Route::post('/pacientes', [PacienteController::class,'createPaciente']);

//Endpoints Tags
Route::get("/tags", [TagsController::class,"getAllTags"]);
Route::get("/tags/{codigo}", [TagsController::class, "getOneTags"]);
Route::post("/tags", [TagsController::class, "createTags"]);
Route::put("/tags/{codigo}", [TagsController::class, "updateTags"]);
Route::delete("/tags/{codigo}", [TagsController::class,"deleteTags"]);

//Endpoints TagsPaciente
Route::apiResource("/tagsPaciente", TagsPacienteController::class);
Route::put("/tagsPaciente/{id}", [TagsPacienteController::class, "update"]);