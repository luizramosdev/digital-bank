<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Extract extends Model
{
    protected $fillable = [
        'uuid',
        'account_id',
        'to_account',
        'amount',
        'drive_type'
    ];

    public function account() {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }
}
