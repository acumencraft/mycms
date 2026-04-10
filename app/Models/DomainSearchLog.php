<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DomainSearchLog extends Model
{
    protected $fillable = [
        'domain',
        'ip',
    ];
}
