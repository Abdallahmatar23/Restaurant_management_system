<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name','category_id','description','display_order','status'])]
class Subcategory extends Model
{
    public function section(){
        return $this->hasOneThrough(Section::class,Category::class,'id','id','category_id','section_id');
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function items (){
        return $this->hasMany(MenuItem::class);
    }
}
