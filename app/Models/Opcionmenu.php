<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opcionmenu extends Model
{
    use HasFactory;
    protected $table = 'opcion_menu';
    protected $fillable = ['nombre','link','idopcion_menu_ref','estado'];
    protected $primaryKey = 'idopcion_menu';



}
