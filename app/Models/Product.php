<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'price', 'category_id', 'display_image_id', 'user_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }

    public function displayImage(): BelongsTo
    {
        return $this->belongsTo(ProductImage::class, 'display_image_id', 'id');
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = $this->makeSlugAttr($value);
    }

    public function makeSlugAttr($value): string
    {
        $alias = make_slug($value, auth()->id());

        if (self::newQuery()->where('slug', $alias)->exists()){
            return $this->makeSlugAttr($value);
        }

        return $alias;
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

}
