<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $fillable = [
        'uuid',
        'name'
    ];

    // relations
    public function agency() {
        return $this->hasMany(Agency::class);
    }
}
