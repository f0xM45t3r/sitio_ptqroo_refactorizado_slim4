<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Principal extends Model
{
    protected $table = 'principal';

    protected $fillable = [
        'intro', 'titulo', 'balazo', 'id_post', 'publicar', 'url_media'  ];
    private $pdo;
    
    
    /**
     * Relación con el modelo Post
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'id_post', 'id');
        // Parámetros:
        // 1. Modelo relacionado (Post)
        // 2. Clave foránea en este modelo (id_post)
        // 3. Clave primaria en el modelo relacionado (id)
    }  
    
}