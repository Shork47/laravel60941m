<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'picture_url'];
    public $timestamps = false;

    public static function create(array $array)
    {
    }

    public function dishes(): HasMany
    {
        return $this->hasMany(Dish::class);
    }
}
