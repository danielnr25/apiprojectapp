<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Miembro extends Model
{
    use HasFactory;
    protected $table = 'miembros';
    protected $fillable = ['nombre','comentario','idproyecto','idusuario','estado'];
    protected $primaryKey = 'idmiembro';

    public function proyecto(){
        return $this->belongsTo(Proyecto::class,'idproyecto');
    }

    public function usuario(){
        return $this->belongsTo(User::class,'idusuario');
    }

}
