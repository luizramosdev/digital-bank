<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pix extends Model
{
    protected $fillable = [
        'uuid',
        'account_id',
        'type_key',
        'pix_key'
    ];

    public function account() {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }
}
