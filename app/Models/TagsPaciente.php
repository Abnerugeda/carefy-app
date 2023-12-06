<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagsPaciente extends Model
{
    use HasFactory;
    protected $table = 'tags_paciente';

    protected $fillable = [
        "Codigo_Paciente",
        "Codigo_Tag"
    ];
}
