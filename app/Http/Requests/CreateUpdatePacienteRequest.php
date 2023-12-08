<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class CreateUpdatePacienteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        $rules = [
            'Codigo_Paciente' => [
                'required',
                'max:50',
                'unique:pacientes'
            ],
            'Nome' => [
                'required',
                'max:255'
            ],
            'CEP' => [
                'required',
                'min:9',
                'max:9'
            ],
            'Logradouro' => [
                'required',
                'max:255'
            ],
            'Bairro' => [
                'required',
                'max:255'
            ],
            'numero_casa' => [
                'required',
                'max:50'
            ],
            'complemento' => [
                'max:255'
            ],
            'UF' => [
                'required',
                'min:2',
                'max:2'
            ],
            'Data_Nascimento' => [
                'required',
                'date',
            ],
            'Telefone' => [
                'required',
                'min:15',
                'max:15'
            ],
            'Tags' =>[
                
            ]
        ];
        if($this->method() === "PUT"){
            $rules["Codigo_Paciente"] = [
                'required',
                'max:50',
                Rule::unique('pacientes')->ignore($this->codigo, 'Codigo_Paciente')
            ];
        }
        return $rules;
    }

    public function messages()
    {
        return [
            "Codigo_Paciente.unique" => "Código de paciente já cadastrado",
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = new Response(['message' => $validator->errors()->first()], 203);
        throw new ValidationException($validator, $response);
    }
}
