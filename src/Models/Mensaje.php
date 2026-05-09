<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mensaje extends Model
{
    protected $table = 'formulario_contacto';

    protected $fillable = [
        'nombre', 'email','telefono','asunto','mensaje','estatus','ip_adress','user_agent','notas_admin'
    ];


}
