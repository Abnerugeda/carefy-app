<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tags_Paciente extends Model
{
    use HasFactory;

    protected $fillable = [
        "Codigo_Paciente",
        "Codigo_Tag"
    ];
}
