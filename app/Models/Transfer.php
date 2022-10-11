<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $fillable = [
        'uuid',
        'from_account',
        'to_account',
        'amount',
        'transfer_type'
    ];

    // relations
    public function account() {
        return $this->belongsTo(Account::class);
    }

}
