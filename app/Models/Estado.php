<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    use HasFactory;
    protected $table = 'estados';
    protected $fillable = ['nombre','comentario','maximo_tareas','idproyecto','estado'];
    protected $primaryKey = 'idestado';

    public function proyecto(){
        return $this->belongsTo(Proyecto::class,'idproyecto');
    }
}
