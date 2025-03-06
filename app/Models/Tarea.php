<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    use HasFactory;
    protected $table = 'tareas';
    protected $fillable = ['nombre','comentario','idarea','estado'];
    protected $primaryKey = 'idtarea';

    public function area(){
        return $this->belongsTo(Area::class,'idarea');
    }

}
