<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HtmlContent extends Model
{
    protected $table = 'post_html_content'; // Tu tabla real
    //public $timestamps = false; // Sin created_at/updated_at
    
    protected $fillable = [
        'post_id',
        'html_content'
    ];
    
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }


}
