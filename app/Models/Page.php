<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title', 'slug', 'content', 'page_title', 'page_subtitle', 'items_count', 'seo_title', 'seo_description', 'status',
        'hero_title', 'hero_subtitle', 'hero_image', 'hero_button_text', 'hero_button_url',
        'portfolio_title', 'portfolio_subtitle', 'services_title', 'services_subtitle',
        'features_title', 'features_subtitle', 'testimonials_title',
        'portfolio_items_count', 'services_items_count', 'features_items_count', 'testimonials_items_count',
        'blog_title', 'blog_subtitle', 'blog_items_count',
        'show_portfolio', 'show_services', 'show_features', 'show_testimonials', 'show_blog', 'section_order',
        'contact_phone', 'contact_email', 'contact_address', 'google_maps_embed', 'working_hours',
    ];

    protected $casts = [
        'status' => 'string',
        'items_count' => 'integer',
        'portfolio_items_count' => 'integer',
        'services_items_count' => 'integer',
        'features_items_count' => 'integer',
        'features_items_count' => 'integer',
        'testimonials_items_count' => 'integer',
        'blog_items_count' => 'integer',
        'show_portfolio' => 'boolean',
        'show_services' => 'boolean',
        'show_testimonials' => 'boolean',
        'show_blog' => 'boolean',
        'show_features' => 'boolean',
        'section_order' => 'array',
    ];
}
