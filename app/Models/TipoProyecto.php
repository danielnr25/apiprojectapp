<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoProyecto extends Model
{
    use HasFactory;
    protected $table =  "tipo_proyecto";
    protected $primaryKey = 'idtipo_proyecto';
    protected $fillable = ['nombre', 'comentario', 'estado'];
}
