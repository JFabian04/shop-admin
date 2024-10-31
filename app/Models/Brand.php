<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'identifier',
        'status'
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function scopeFilterName($query, $name)
    {
        if ($name) {
            $query->where('name', 'LIKE', "$name%");
        }
    }
}
