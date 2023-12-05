<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUpdatePacienteRequest;
use App\Http\Resources\PacienteResource;
use App\Models\Pacientes;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use PhpParser\Node\Stmt\TryCatch;



class PacienteController extends Controller
{
    /**
     * @OA\Get(
     *     path="/pacientes",
     *     summary="colete todas as informações",
     *     tags={"Pacientes"},
     *     description="Coletar todos os dados de todos os pacientes",
     *     @OA\Response(response="200", description="Sucesso"),
     *     @OA\Response(response="500", description="Erro no sistema"),
     * )
     */


    public function getAllPacientes()
    {

        try {
            $paciente = Pacientes::paginate();
            return PacienteResource::collection($paciente);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    /**
     * @OA\Get(
     *     path="/pacientes/{id}",
     *     summary="Colete a informação de apenas um Paciente",
     *     tags={"Pacientes"},
     *     description="Coletar todos os dados de todos os pacientes",
     *     @OA\Response(response="200", description="Sucesso"),
     *     @OA\Response(response="202", description="Paciente não encontrado"),
     *     @OA\Response(response="500", description="Erro no sistema"),
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Buscar por id",
     *         required=true,
     *      ),
     * )
     */

    public function getOnePaciente(string $id)
    {
        try {
            $paciente = Pacientes::find($id);
            if (!$paciente) {
                return response()->json(['message' => 'Paciente não encontrado'], 202);
            }
            return new PacienteResource($paciente);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     * path="/pacientes",
     * summary="",
     * description="Crie seu paciente",
     * tags={"Pacientes"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Insira corretamente todas as informações",
     *    @OA\JsonContent(
     *       @OA\Property(property="Codigo_Paciente", type="int", example="1234"),
     *       @OA\Property(property="Nome", type="string", example="Abner Ugeda"),
     *       @OA\Property(property="CEP", type="string", example="00000-000"),
     *       @OA\Property(property="Logradouro", type="string", example="Rua floriano"),
     *       @OA\Property(property="Bairro", type="string", example="Rua floriano"),
     *       @OA\Property(property="numero_casa", type="int", example="123"),
     *       @OA\Property(property="complemento", type="string", example="apto 71"),
     *       @OA\Property(property="UF", type="string", example="SP"),
     *       @OA\Property(property="Data_Nascimento", type="date", example="2023-01-01"),
     *       @OA\Property(property="Telefone", type="string", example="(16) 99792-6503")
     *    )
     * ),
     * @OA\Response(
     *    response=201,
     *    description="Sucesso! Usuário foi cadastrado"
     * ),
     * @OA\Response(
     *    response=500,
     *    description="Erro no sistema"
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Código do paciente já cadastrado",
     *    @OA\JsonContent()
     * ),
     * @OA\Response(
     *    response=404,
     *    description="Informações inválidas"
     * )
     * )
     */

    public function createPaciente(CreateUpdatePacienteRequest $request)
    {
        try {
            $paciente = Pacientes::create($request->validated());
            return new PacienteResource($paciente);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Put(
     * path="/pacientes/{id}",
     * summary="",
     * description="Edite o seu paciente",
     * tags={"Pacientes"},
     * @OA\RequestBody(
     *    request="UpdatePacienteRequest",
     *    required=true,
     *    description="Insira corretamente todas as informações",
     *    @OA\JsonContent(
     *       @OA\Property(property="Codigo_Paciente", type="int", example="1234"),
     *       @OA\Property(property="Nome", type="string", example="Abner Ugeda"),
     *       @OA\Property(property="CEP", type="string", example="00000-000"),
     *       @OA\Property(property="Logradouro", type="string", example="Rua floriano"),
     *       @OA\Property(property="Bairro", type="string", example="Rua floriano"),
     *       @OA\Property(property="numero_casa", type="int", example="123"),
     *       @OA\Property(property="complemento", type="string", example="apto 71"),
     *       @OA\Property(property="UF", type="string", example="SP"),
     *       @OA\Property(property="Data_Nascimento", type="date", example="2023-01-01"),
     *       @OA\Property(property="Telefone", type="string", example="(16) 99792-6503")
     *    )
     * ),
     *  @OA\Parameter(
     *      name="id",
     *      in="path",
     *      description="Buscar por id",
     *      required=true,
     * ),
     * @OA\Response(
     *    response=201,
     *    description="Sucesso! Usuário foi cadastrado"
     * ),
     * @OA\Response(
     *    response=500,
     *    description="Erro no sistema"
     * ),
     * @OA\Response(
     *    response=202,
     *    description="Paciente não encontrado",
     *    
     * ),
     * @OA\Response(
     *    response=404,
     *    description="Informações inválidas"
     * )
     * )
     */

    public function updatePaciente(CreateUpdatePacienteRequest $request, string $id)
    {
        try {
            $paciente = Pacientes::find($id);
            if (!$paciente) {
                return response()->json(['message' => 'Paciente não encontrado'], 202);
            }
            $paciente->update($request->validated());
            return new PacienteResource($paciente);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
