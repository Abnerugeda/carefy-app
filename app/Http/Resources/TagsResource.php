<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TagsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {        
        return [
            "Codigo_Tag" => $this->Codigo_Tag,
            "Nome" => $this->Nome,
            "Cor" => $this->Cor,
            "Descricao" => $this->Descricao,
        ];
    }
}
