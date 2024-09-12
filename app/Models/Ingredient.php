<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ingredient extends Model
{
    use HasFactory;
    public function dishes(): BelongsToMany
    {
        return $this->belongsToMany(Dish::class, 'recipes')
            ->withPivot(['quantity']);
    }
}
