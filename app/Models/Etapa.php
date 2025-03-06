<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etapa extends Model
{
    use HasFactory;
    protected $table = 'etapas';
    protected $fillable = ['nombre','comentario','fecha_inicio','fecha_fin','idproyecto','idusuario','estado'];
    protected $primaryKey = 'idetapa';


    public function proyecto(){
        return $this->belongsTo(Proyecto::class,'idproyecto');
    }

    public function usuario(){
        return $this->belongsTo(User::class,'idusuario');
    }




}
