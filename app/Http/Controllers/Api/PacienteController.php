<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PacienteResource;
use App\Models\Pacientes;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    public function getAllPacientes(){
        
        $paciente = Pacientes::all();

        return PacienteResource::collection($paciente);
    }
}
