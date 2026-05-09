<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $table = 'promotions';

    protected $fillable = [
        'title',
        'image_path',
        'link_url',
        'button_text',
        'event_date',
        'event_location',
        'is_active',
        'starts_at',
        'ends_at'
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_active' => 'boolean'
    ];
    
    /**
     * Scope para obtener solo las promociones vigentes (Pop-up)
     */
    public function scopeActive($query)
    {
        $now = date('Y-m-d H:i:s');
        return $query->where('is_active', true)
                     ->where(function($q) use ($now) {
                         $q->whereNull('starts_at')
                           ->orWhere('starts_at', '<=', $now);
                     })
                     ->where(function($q) use ($now) {
                         $q->whereNull('ends_at')
                           ->orWhere('ends_at', '>=', $now);
                     });
    }

    /**
     * Scope para obtener los próximos eventos (Agenda)
     */
    public function scopeUpcoming($query)
    {
        return $query->where('is_active', true)
                     ->where('event_date', '>=', date('Y-m-d'))
                     ->orderBy('event_date', 'asc');
    }
}
