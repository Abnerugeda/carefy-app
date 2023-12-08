<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUpdatePacienteRequest;
use App\Http\Resources\PacienteResource;
use App\Models\Pacientes;
use App\Models\Tags;
use App\Models\TagsPaciente;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Routing\Route;
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
            $paciente = Pacientes::where('data_exclusao', '=', null)->with('tags')->paginate();

            return PacienteResource::collection($paciente);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    /**
     * @OA\Get(
     *     path="/pacientes/{codigo}",
     *     summary="Colete a informação de apenas um Paciente",
     *     tags={"Pacientes"},
     *     description="Coletar todos os dados de um paciente pelo seu codigo",
     *     @OA\Response(response="200", description="Sucesso"),
     *     @OA\Response(response="202", description="Paciente não encontrado"),
     *     @OA\Response(response="500", description="Erro no sistema"),
     *     @OA\Parameter(
     *         name="codigo",
     *         in="path",
     *         description="Buscar por codigo",
     *         required=true,
     *      ),
     * )
     */

    public function getOnePaciente(string $codigo)
    {
        try {
            $paciente = Pacientes::where("Codigo_Paciente", "=", $codigo)->first();
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
     * path="/pesquisarPaciente",
     * summary="",
     * description="Digite o termo necessario para realizar a sua consulta, qualquer informação é bem aceita.",
     * tags={"Pacientes"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Insira corretamente todas as informações",
     *    @OA\JsonContent(
     *      @OA\Property(property="termo", type="string", example="Abner")
     *    )
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
     * )
     */

    public function pesquisarPaciente(Request $request)
    {
        try {
            $termoPesquisa = $request->input('termo');
            $pacientes = Pacientes::where(function ($query) use ($termoPesquisa) {
                $query->where('Nome', 'like', "%$termoPesquisa%")
                    ->orWhere('Codigo_Paciente', 'like', "%$termoPesquisa%")
                    ->orWhere('Telefone', 'like', "%$termoPesquisa%")
                    ->orWhere('Data_Nascimento', 'like', "%$termoPesquisa%");
            })
                ->whereNull('data_exclusao')
                ->get();
            return PacienteResource::collection($pacientes);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/pacientes/codigoTag/{codigo}",
     *     summary="Colete a informação um paciente por tag",
     *     tags={"Pacientes"},
     *     description="Coletar todos os dados de um paciente pelo seu codigo",
     *     @OA\Response(response="200", description="Sucesso"),
     *     @OA\Response(response="500", description="Erro no sistema"),
     *     @OA\Parameter(
     *         name="codigo",
     *         in="path",
     *         description="Buscar por codigo",
     *         required=true,
     *      ),
     * )
     */


    public function filtrarPorTag(string $codigoTag)
    {
        try {
            $pacientes = Pacientes::whereHas('tags', function ($query) use ($codigoTag) {
                $query->where('tags.Codigo_Tag', $codigoTag);
            })->where(function ($query) {
                $query->whereNull('data_exclusao');
            })->get();
            return PacienteResource::collection($pacientes);
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
     *    description="Insira corretamente todas as informações, obs: A tag para ser vinculada junto ao paciente neste cadastro, ela deve já existir!",
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
     *       @OA\Property(property="Telefone", type="string", example="(16) 99792-6503"),
     *       @OA\Property(property="Tags", type="array",  @OA\Items(
     *         type="object",
     *         @OA\Property(property="Codigo_Tag", type="string", example="123"),
     *         @OA\Property(property="Codigo_Paciente", type="string", example="123"),
     *     )),
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
            $tagsData = $request->input('Tags');
            $paciente->tags()->attach($tagsData);

            return new PacienteResource($paciente);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Put(
     * path="/pacientes/{codigo}",
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
     *       @OA\Property(property="Telefone", type="string", example="(16) 99792-6503"),
     *       @OA\Property(property="Tags", type="array",  @OA\Items(
     *         type="object",
     *         @OA\Property(property="Codigo_Tag", type="string", example="123"),
     *         @OA\Property(property="Codigo_Paciente", type="string", example="123"),
     *     )),
     *    )
     * ),
     *  @OA\Parameter(
     *      name="codigo",
     *      in="path",
     *      description="Buscar por codigo",
     *      required=true,
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Sucesso! Paciente foi editado"
     * ),
     *  @OA\Response(
     *    response=203,
     *    description="Código já cadastrado em outro paciente"
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

    public function updatePaciente(CreateUpdatePacienteRequest $request, string $codigo)
    {
        try {
            $paciente = Pacientes::where("Codigo_Paciente", "=", $codigo)->first();
            if (!$paciente) {
                return response()->json(['message' => 'Paciente não encontrado'], 202);
            }
            $paciente->update($request->validated());
            $tagsData = $request->input('Tags', []);

            $paciente->tags()->detach();

            foreach ($tagsData as $tag) {
                $paciente->tags()->attach($tag['Codigo_Tag']);
            }

            return new PacienteResource($paciente);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    /**
     * @OA\Delete(
     *     path="/pacientes/{codigo}",
     *     summary="Delete um paciente",
     *     tags={"Pacientes"},
     *     description="Deletar paciente por codigo",
     *     @OA\Response(response="200", description="Sucesso"),
     *     @OA\Response(response="202", description="Paciente não encontrado"),
     *     @OA\Response(response="500", description="Erro no sistema"),
     *     @OA\Parameter(
     *         name="codigo",
     *         in="path",
     *         description="Deletar por codigo",
     *         required=true,
     *      ),
     * )
     */


    public function deletePaciente(string $codigo)
    {
        try {
            $paciente = Pacientes::where("Codigo_Paciente", "=", $codigo)->first();
            if (!$paciente) {
                return response()->json(['message' => 'Paciente não encontrado'], 202);
            }
            $paciente->data_exclusao = now();
            $paciente->save();
            return response()->json(['message' => "Paciente deletado com sucesso!"], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
