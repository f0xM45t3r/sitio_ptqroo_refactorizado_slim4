<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Author extends Model
{
    protected $table = 'authors';

    protected $fillable = [
        'display_name', 'charge', 'slug', 'bio', 'url_media'
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
