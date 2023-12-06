<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PacienteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'Codigo_Paciente' => $this->Codigo_Paciente,
            'Nome' => $this->Nome,
            'CEP' => $this->CEP,
            'Logradouro' => $this->Logradouro,
            'Bairro' => $this->Bairro,
            'Numero_Casa' => $this->numero_casa,
            'Complemento'=> $this->complemento ,
            'UF'=> $this->UF,
            'Data_Nascimento' => Carbon::make($this->Data_Nascimento)->format('d/m/Y'),
            'Telefone' => $this->Telefone,
        ];
    }
}
