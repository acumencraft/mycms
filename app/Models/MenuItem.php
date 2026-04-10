<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $fillable = [
        'label', 'url', 'location', 'position', 'is_active', 'open_in_new_tab'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'open_in_new_tab' => 'boolean',
    ];

    public static function getByLocation(string $location)
    {
        return static::where('location', $location)
            ->where('is_active', true)
            ->orderBy('position')
            ->get();
    }
}
