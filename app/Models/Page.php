<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title', 'slug', 'content', 'seo_title', 'seo_description', 'status',
        'hero_title', 'hero_subtitle', 'hero_image', 'hero_button_text', 'hero_button_url',
        'portfolio_title', 'portfolio_subtitle', 'services_title', 'services_subtitle',
        'features_title', 'features_subtitle', 'testimonials_title',
        'contact_phone', 'contact_email', 'contact_address', 'google_maps_embed', 'working_hours',
    ];

    protected $casts = [
        'status' => 'string',
    ];
}
