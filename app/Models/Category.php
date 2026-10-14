<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['section_id', 'name', 'description', 'display_order', 'status'];

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
