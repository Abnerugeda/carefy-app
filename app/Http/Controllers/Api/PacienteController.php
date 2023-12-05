<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PacienteResource;
use App\Models\Pacientes;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use PhpParser\Node\Stmt\TryCatch;

class PacienteController extends Controller
{
    public function getAllPacientes()
    {

        try {
            $paciente = Pacientes::paginate();
            return PacienteResource::collection($paciente);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function createPaciente(Request $request)
    {

        try {
            $paciente = Pacientes::create($request->all());
            return new PacienteResource($paciente);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
