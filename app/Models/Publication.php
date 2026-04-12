<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Publication extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'author_id',
        'status',
        'published_at',
        'is_published',
        'cover_image',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_published' => 'boolean',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(PublicationCategory::class, 'publication_category_publication');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(PublicationTag::class, 'publication_tag_map');
    }

    // სუფთა relation — filtering controller/eager loading-ში
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    // approved root comments — view-ში გამოსაყენებლად
    public function approvedComments(): HasMany
    {
        return $this->hasMany(Comment::class)
                    ->whereNull('parent_id')
                    ->where('is_approved', true)
                    ->latest();
    }
}
