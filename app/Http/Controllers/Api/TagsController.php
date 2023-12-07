<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUpdateTagsRequest;
use App\Http\Resources\TagsResource;
use App\Models\Tags;
use Exception;
use Illuminate\Http\Request;

class TagsController extends Controller
{

    /**
     * @OA\Get(
     *     path="/tags",
     *     summary="colete todas as informações",
     *     tags={"Tags"},
     *     description="Coletar todos os dados de todos as Tags",
     *     @OA\Response(response="200", description="Sucesso"),
     *     @OA\Response(response="500", description="Erro no sistema"),
     * )
     */

    public function getAllTags()
    {
        try {
            $tags = Tags::where('data_exclusao', '=', null)->paginate();
            return TagsResource::collection($tags);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }



    /**
     * @OA\Get(
     *     path="/tags/{codigo}",
     *     summary="Colete a informação de apenas uma Tag pelo Código de Tag",
     *     tags={"Tags"},
     *     description="Coletar os dados de uma tag pelo seu código",
     *     @OA\Response(response="200", description="Sucesso"),
     *     @OA\Response(response="202", description="Tag não encontrada"),
     *     @OA\Response(response="500", description="Erro no sistema"),
     *     @OA\Parameter(
     *         name="codigo",
     *         in="path",
     *         description="Buscar por codigo da tag",
     *         required=true,
     *      ),
     * )
     */

    public function getOneTags(string $codigo)
    {
        try {
            $tags = Tags::where('Codigo_Tag', "=", $codigo)->first();
            if (!$tags) {
                return response()->json(['message' => 'Tag não encontrada', "codigo" => $codigo], 202);
            }
            return new TagsResource($tags);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     * path="/tags",
     * summary="",
     * description="Crie sua tag",
     * tags={"Tags"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Insira corretamente todas as informações",
     *    @OA\JsonContent(
     *       @OA\Property(property="Codigo_Tag", type="string", example="a123"),
     *       @OA\Property(property="Nome", type="string", example="Tag 1"),
     *       @OA\Property(property="Cor", type="string", example="#ffffff"),
     *       @OA\Property(property="Descricao", type="string", example="Tag exemplo"),
     *    )
     * ),
     * @OA\Response(
     *    response=201,
     *    description="Sucesso! Tag foi cadastrada"
     * ),
     * @OA\Response(
     *    response=500,
     *    description="Erro no sistema"
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Código da tag já cadastrada",
     *    @OA\JsonContent()
     * ),
     * @OA\Response(
     *    response=404,
     *    description="Informações inválidas"
     * )
     * )
     */

    public function createTags(CreateUpdateTagsRequest $request)
    {
        try {
            $tags = Tags::create($request->validated());
            return new TagsResource($tags);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Put(
     * path="/tags/{codigo}",
     * summary="",
     * description="Crie sua tag",
     * tags={"Tags"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Insira corretamente todas as informações",
     *    @OA\JsonContent(
     *       @OA\Property(property="Codigo_Tag", type="string", example="a123"),
     *       @OA\Property(property="Nome", type="string", example="Tag 1"),
     *       @OA\Property(property="Cor", type="string", example="#ffffff"),
     *       @OA\Property(property="Descricao", type="string", example="Tag exemplo"),
     *    )
     * ),
     * @OA\Parameter(
     *    name="codigo",
     *    in="path",
     *    description="Buscar por codigo",
     *    required=true,
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Sucesso! Tag foi cadastrada"
     * ),
     * @OA\Response(
     *    response=202,
     *    description="Tag não encontrada"
     * ),
     * @OA\Response(
     *    response=500,
     *    description="Erro no sistema"
     * ),
     * @OA\Response(
     *    response=203,
     *    description="Código da tag já cadastrada",
     *    @OA\JsonContent()
     * ),
     * @OA\Response(
     *    response=404,
     *    description="Informações inválidas"
     * )
     * )
     */
    public function updateTags(CreateUpdateTagsRequest $request, string $codigo)
    {
        try {
            $tags = Tags::where("Codigo_Tag", "=", $codigo)->first();
            if (!$tags) {
                return response()->json(['message' => 'Tag não encontrada'], 202);
            }
            $tags->update($request->validated());
            return new TagsResource($tags);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    /**
     * @OA\Delete(
     *     path="/tags/{codigo}",
     *     summary="Delete uma tag",
     *     tags={"Tags"},
     *     description="Deletar tag por codigo",
     *     @OA\Response(response="200", description="Sucesso"),
     *     @OA\Response(response="202", description="Tag não encontrada"),
     *     @OA\Response(response="500", description="Erro no sistema"),
     *     @OA\Parameter(
     *         name="codigo",
     *         in="path",
     *         description="Deletar por codigo",
     *         required=true,
     *      ),
     * )
     */

    public function deleteTags(string $codigo)
    {
        try {
            $tags = Tags::where("Codigo_Tag", "=", $codigo)->first();
            if (!$tags) {
                return response()->json(['message' => 'Tag não encontrada'], 202);
            }
            $tags->data_exclusao = now();
            $tags->save();
            return response()->json(['message'=> "Paciente deletado com sucesso!", "teste"=>now()], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
