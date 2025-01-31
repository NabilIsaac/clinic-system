<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock_quantity',
        'unit',
        'category_id',
        'sku',
        'reorder_level',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'reorder_level' => 'integer',
    ];

    protected $appends = ['image_url'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function needsReorder()
    {
        return $this->stock_quantity <= $this->reorder_level;
    }

    public function isOutOfStock()
    {
        return $this->stock_quantity <= 0;
    }

    public function getTotalValueAttribute()
    {
        return $this->stock_quantity * $this->price;
    }

    public function getImageUrlAttribute()
    {
        return $this->getFirstMediaUrl('image') ?: asset('images/default-product.png');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(100)
            ->height(100);

        $this->addMediaConversion('preview')
            ->width(400)
            ->height(400);
    }
}
