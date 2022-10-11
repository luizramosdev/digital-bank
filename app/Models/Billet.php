<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billet extends Model
{
    protected $fillable = [
        'uuid',
        'account_id',
        'bar_code',
        'amount',
        'due_date',
        'payment_status'
    ];

    // relations
    public function account() {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }
}
