<?php
// app/Models/Libro.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{
    protected $table = 'libros';
    
    protected $primaryKey = 'id';
    
    public $timestamps = true;
    
    protected $fillable = [
        'titulo',
        'editorial',
        'numero',
        'url_media',
        'url_pdf'
    ];
    
    protected $casts = [
        'numero' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
    
    // Accesores para URLs completas si están almacenadas como rutas relativas
    public function getUrlMediaCompletaAttribute()
    {
        return $this->url_media ? asset('storage/' . $this->url_media) : null;
    }
    
    public function getUrlPdfCompletaAttribute()
    {
        return $this->url_pdf ? asset('storage/' . $this->url_pdf) : null;
    }
}