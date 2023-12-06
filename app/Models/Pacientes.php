<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pacientes extends Model
{
    use HasFactory;
    protected $primaryKey = 'Codigo_Paciente';

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
