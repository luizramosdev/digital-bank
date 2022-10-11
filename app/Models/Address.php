<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'uuid',
        'zip_code',
        'street',
        'number',
        'complement',
        'neighborhood',
        'city',
        'state'
    ];

    // relations
    public function user() {
        return $this->belongsTo(User::class);
    }
}
