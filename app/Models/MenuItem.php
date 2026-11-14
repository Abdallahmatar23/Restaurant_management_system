<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'subcategory_id', 'image', 'description', 'availability', 'price', 'preparation_time','tags'])]
class MenuItem extends Model
{
    protected $casts = [
        'price' => 'decimal:2',
        'tags' => 'array'
    ];

    public function getSectionAttribute()
    {
        return $this->subcategory?->category?->section;
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }
    public function offers()
    {
        return $this->belongsToMany(Offer::class);
    }
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_items');
    }
}
