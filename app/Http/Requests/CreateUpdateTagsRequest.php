<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CreateUpdateTagsRequest extends FormRequest
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
            "Codigo_Tag"=>[
                "required",
                "max:50",
                "unique:tags"
            ],
            "Nome"=> [
                'required',
                'max:100'
            ],
            "Cor"=>[
                "required",
                "max:7",
                "min:7"
            ],
            "Descricao"=>[
                "max:255"
            ]
        ];  

        if($this->method() === "PUT"){
            $rules["Codigo_Tag"] = [
                'required',
                'max:50',
                Rule::unique('tags')->ignore($this->id)
            ];
        }
        
        return $rules; 
    }

    public function messages()
    {
        return [
            "Codigo_Tag.unique" => "Código da Tag já cadastrada",
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = new Response(['message' => $validator->errors()->first()], 200);
        throw new ValidationException($validator, $response);
    }
}
