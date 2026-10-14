<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $fillable = [
        'subcategory_id',
        'name',
        'description',
        'price',
        'image',
        'preparation_time',
        'availability'
    ];

    protected $casts = ['price' => 'decimal:2'];

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }
}
