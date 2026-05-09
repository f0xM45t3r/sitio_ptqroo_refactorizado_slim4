<?php
// app/Models/Revista.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Revista extends Model
{
    protected $table = 'revistas';
    
    protected $primaryKey = 'id';
    
    public $timestamps = true;
    
    protected $fillable = [
        'titulo',
        'descripcion',
        'url_media',
        'articulo1',
        'balazo1',
        'articulo2',
        'balazo2'
    ];
    
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
    
    // Búsqueda full-text (requiere índice FULLTEXT en MariaDB)
    public function scopeBusqueda($query, $termino)
    {
        return $query->whereRaw(
            "MATCH(titulo, descripcion, balazo1, balazo2) AGAINST(? IN BOOLEAN MODE)", 
            [$termino]
        );
    }
    
    // Accesor para URL media completa
    public function getUrlMediaCompletaAttribute()
    {
        return $this->url_media ? asset('storage/' . $this->url_media) : null;
    }
}