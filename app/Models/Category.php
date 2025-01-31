<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'type',
        'description',
    ];

    public function drugs()
    {
        return $this->hasMany(Drug::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function items()
    {
        return $this->type === 'drug' ? $this->drugs() : $this->products();
    }
}
