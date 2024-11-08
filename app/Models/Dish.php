<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dish extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'cooking_method',
        'cooking_time',
        'category_id',
        'user_id',
    ];
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function ingredient(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class, 'recipes')
            ->withPivot('quantity');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function photo(): HasMany
    {
        return $this->HasMany(Photo::class);
    }
}
