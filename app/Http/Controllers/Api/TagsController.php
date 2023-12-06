<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
            $tags = Tags::paginate();
            return TagsResource::collection($tags);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }



    /**
     * @OA\Get(
     *     path="/tags/{id}",
     *     summary="Colete a informação de apenas uma Tag",
     *     tags={"Tags"},
     *     description="Coletar os dados de uma Tag pelo seu id",
     *     @OA\Response(response="200", description="Sucesso"),
     *     @OA\Response(response="202", description="Tag não encontrada"),
     *     @OA\Response(response="500", description="Erro no sistema"),
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Buscar por id",
     *         required=true,
     *      ),
     * )
     */

    public function getOneTags(string $id)
    {
        try {
            $tags = Tags::find($id);
            if (!$tags) {
                return response()->json(['message' => 'Tags não encontrada'], 202);
            }
            return new TagsResource($tags);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
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

    public function getWithCode(string $codigo){
        try {
            $tags = Tags::where('Codigo_Tags', $codigo)->first();

            if (!$tags) {
                return response()->json(['message' => 'Tags não encontrada'], 202);
            }
            return new TagsResource($tags);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}


