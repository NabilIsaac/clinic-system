<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Drug extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'name',
        'generic_name',
        'description',
        'price',
        'stock_quantity',
        'unit',
        'category_id',
        'sku',
        'reorder_level'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'reorder_level' => 'integer'
    ];

    protected $appends = ['image_url'];

    public function prescriptionDrugs()
    {
        return $this->hasMany(PrescriptionDrug::class);
    }

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
        return $this->getFirstMediaUrl('image') ?: asset('assets/images/placeholder.jpeg');
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
    
    // If you need to access the drugs directly
    public function drugs()
    {
        return $this->belongsToMany(Drug::class, 'drug_order')
            ->withPivot(['quantity', 'price']);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity', 'price');
    }

}
