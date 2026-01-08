<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['title','slug','description','duration_minutes','price','is_active'];

    public function slots()
    {
        return $this->hasMany(Slot::class);
    }
}
