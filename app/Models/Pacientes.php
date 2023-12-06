<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pacientes extends Model
{
    use HasFactory;
    protected $primaryKey = 'Codigo_Paciente';
    protected $casts = [
        'Codigo_Paciente' => 'string',
    ];

    public function tags()
    {
        return $this->belongsToMany(Tags::class, 'tags_pacientes', 'Codigo_Paciente', 'Codigo_Tag');
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'Codigo_Paciente',
        'Nome',
        'CEP',
        'Logradouro',
        'Bairro',
        'numero_casa',
        'complemento',
        'UF',
        'Data_Nascimento',
        'Telefone',
    ];
}
