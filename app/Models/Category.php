<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'section_id', 'description', 'display_order', 'status'])]
class Category extends Model
{
    public function section()
    {
        return $this->belongsTo(Section::class);
    }
    public function subcategories()
    {
        return $this->hasMany(Subcategory::class)->orderBy('display_order');
    }
    public function items()
    {
        return $this->hasManyThrough(MenuItem::class, Subcategory::class);
    }
}
