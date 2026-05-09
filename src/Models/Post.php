<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    protected $table = 'posts';

    protected $fillable = [
        'author_id', 'category_id', 'user_id', 'title', 'slug', 'quote', 'content', 'url_media', 'published_at', 'html_content_id'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];
    
    protected $casts = [
        'published_at' => 'datetime'
    ];


    
    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function htmlContent(): HasOne
    {
        return $this->hasOne(HtmlContent::class, 'post_id', 'id');
    }

    /**
     * Relación inversa con Principal
     */
    public function principal(): HasOne
    {
        return $this->hasOne(Principal::class, 'id_post', 'id');
        // Parámetros:
        // 1. Modelo relacionado (Principal)
        // 2. Clave foránea en el modelo relacionado (id_post)
        // 3. Clave primaria en este modelo (id)
    }

/*// Accessor para obtener el HTML directamente
public function getHtmlContentAttribute()
{
    return $this->htmlContent?->html_content;
}

// Método para crear post con contenido HTML
public static function createWithHtml($postData, $htmlContent)
{
    // Crear primero el contenido HTML
    $content = PostHtmlContent::create([
        'html_content' => $htmlContent
    ]);
    
    // Crear el post con referencia al contenido
    return self::create(array_merge($postData, [
        'html_content_id' => $content->id
    ]));
}

*/

}
