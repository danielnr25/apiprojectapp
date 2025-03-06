<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;
    protected $table = 'proyectos';
    protected $fillable = ['nombre','idtipo_proyecto','fecha_inicio','fecha_fin','detalle','estado','idusuario'];
    protected $primaryKey = 'idproyecto';

    public function tipo_proyecto(){
        return $this->belongsTo(TipoProyecto::class,'idtipo_proyecto');
    }

    public function usuario(){
        return $this->belongsTo(User::class,'idusuario');
    }

}
