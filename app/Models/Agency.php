<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    protected $fillable = [
        'uuid',
        'bank_id',
        "number_agency"
    ];

    // relations
    public function bank() {
        return $this->belongsTo(Bank::class, 'bank_id', 'id');
    }

    public function account() {
        return $this->hasMany(Account::class);
    }
}
