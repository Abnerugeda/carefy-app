<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    use HasFactory;
    protected $primaryKey = 'Codigo_Tag';

    public function pacientes()
    {
        return $this->belongsToMany(Pacientes::class, 'tags_pacientes', 'Codigo_Tag', 'Codigo_Paciente');
    }

    protected $casts = [
        'Codigo_Tag' => 'string',
    ];
    
    protected $fillable = [
        "Nome",
        "Codigo_Tag",
        "Cor",
        "Descricao"
    ];
}
