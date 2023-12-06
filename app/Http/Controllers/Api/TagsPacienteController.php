<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUpdateTagsPacienteRequest;
use App\Http\Resources\TagsPacienteResource;
use App\Models\Tags_Paciente;
use App\Models\TagsPaciente;
use Exception;
use Illuminate\Http\Request;

class TagsPacienteController extends Controller
{
    /**
     * @OA\Get(
     *     path="/tagsPaciente",
     *     summary="colete todas as informações",
     *     tags={"TagsPaciente"},
     *     description="Coletar todos os dados de todos as Tags vinculadas com o paciente",
     *     @OA\Response(response="200", description="Sucesso"),
     *     @OA\Response(response="500", description="Erro no sistema"),
     * )
     */

    public function index(){
        try{
            $tagPaciente = TagsPaciente::paginate();
            return TagsPacienteResource::collection($tagPaciente);
        }catch(Exception $e){
            return response()->json(["message"=>$e->getMessage()],500);
        }
    }

      /**
     * @OA\Post(
     * path="/tagsPaciente",
     * summary="",
     * description="Vincule sua tag ao seu paciente",
     * tags={"TagsPaciente"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Insira corretamente todas as informações",
     *    @OA\JsonContent(
     *       @OA\Property(property="Codigo_Tag", type="string", example="a123"),
     *       @OA\Property(property="Codigo_Paciente", type="string", example="a123"),
     *    )
     * ),
     * @OA\Response(
     *    response=201,
     *    description="Sucesso!"
     * ),
     * @OA\Response(
     *    response=500,
     *    description="Erro no sistema"
     * ),
     * @OA\Response(
     *    response=404,
     *    description="Informações inválidas"
     * )
     * )
     */

    public function store(CreateUpdateTagsPacienteRequest $request){
        try{
            
            $tagsPaciente = TagsPaciente::create($request->validated());
            return new TagsPacienteResource($tagsPaciente);
        }catch(Exception $e){
            return response()->json(["message"=>$e->getMessage()],500);
        }
    }

    /**
     * @OA\Get(
     *     path="/tagsPaciente/{id}",
     *     summary="Colete a informação de apenas uma Tag vinculada ao paciente pelo id",
     *     tags={"TagsPaciente"},
     *     description="Coletar os dados de uma tag paciente pelo seu id",
     *     @OA\Response(response="200", description="Sucesso"),
     *     @OA\Response(response="202", description="Tag Paciente não encontrada"),
     *     @OA\Response(response="500", description="Erro no sistema"),
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Buscar por id ",
     *         required=true,
     *      ),
     * )
     */

    public function show(string $id){
        try{
            $tagPaciente = TagsPaciente::find($id);
            if(!$tagPaciente){
                return response()->json(["message"=>"Tag paciente não encontrado"],202);
            }
            return new TagsPacienteResource($tagPaciente);
        }catch(Exception $e){
            return response()->json(["message"=>$e->getMessage()],500);
        }
    }


      /**
     * @OA\Put(
     * path="/tagsPaciente/{id}",
     * summary="",
     * description="Edite sua tag ao seu . O codigo da tag e do paciente deve existir para que funcione.",
     * tags={"TagsPaciente"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Insira corretamente todas as informações",
     *    @OA\JsonContent(
     *       @OA\Property(property="Codigo_Tag", type="string", example="a123"),
     *       @OA\Property(property="Codigo_Paciente", type="string", example="a123"),
     *    )
     * ),
     *  @OA\Parameter(
     *      name="id",
     *      in="path",
     *      description="Buscar por id ",
     *      required=true,
     *  ),
     * @OA\Response(
     *    response=201,
     *    description="Sucesso!"
     * ),
     * @OA\Response(
     *    response=202,
     *    description="Sucesso!"
     * ),
     * @OA\Response(
     *    response=500,
     *    description="Erro no sistema"
     * ),
     * @OA\Response(
     *    response=404,
     *    description="Informações inválidas"
     * )
     * )
     */


    public function update(CreateUpdateTagsPacienteRequest $request, string $id){
        try {
            $tagsPaciente = TagsPaciente::find($id);
            if (!$tagsPaciente) {
                return response()->json(['message' => 'Tag Paciente não encontrada'], 202);
            }
            $tagsPaciente->update($request->validated());
            return new TagsPacienteResource($tagsPaciente);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

     /**
     * @OA\Delete(
     *     path="/tagsPaciente/{id}",
     *     summary="Delete uma Tag vinculada ao paciente pelo id",
     *     tags={"TagsPaciente"},
     *     description="Deletar tag paciente pelo id",
     *     @OA\Response(response="200", description="Sucesso"),
     *     @OA\Response(response="202", description="Tag Paciente não encontrada"),
     *     @OA\Response(response="500", description="Erro no sistema"),
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Deletar por id ",
     *         required=true,
     *      ),
     * )
     */

    public function destroy(string $id){
        try {
            $tagsPaciente = TagsPaciente::find($id);
            if (!$tagsPaciente) {
                return response()->json(['message' => 'Tag Paciente não encontrada'], 202);
            }
            $tagsPaciente->delete();
            return response()->json(["message"=> "Tag paciente deletada com sucesso"], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

}
