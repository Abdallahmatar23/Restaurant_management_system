<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    public function items()
    {
        return $this->BelongsToMany(MenuItem::class);
    }
}
