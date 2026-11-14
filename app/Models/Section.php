<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;


#[Fillable(['name','description','display_order','status'])]
class Section extends Model
{
    // protected $fillable = [
    //     'name',
    //     'description',
    //     'display_order',
    //     'status'
    // ];
    public function categories()
    {
        return $this->hasMany(Category::class)->orderBy('display_order');
    }
        public function subcategories()
    {
        return $this->hasManyThrough(Subcategory::class,Category::class)->orderBy('display_order');
    }
}
