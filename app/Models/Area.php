<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;
    protected $table = 'areas';
    protected $fillable = ['nombre','comentario','idproyecto','estado'];
    protected $primaryKey = 'idarea';

    public function proyecto(){
        return $this->belongsTo(Proyecto::class,'idproyecto');
    }

}
