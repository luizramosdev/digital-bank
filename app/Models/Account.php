<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'uuid',
        'agency_id',
        'user_id',
        'account_number',
        'balance',
        'status'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    // relations
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function agency() {
        return $this->belongsTo(Agency::class, 'agency_id', 'id');
    }

    public function transfer() {
        return $this->hasMany(Transfer::class);
    }

    public function billet() {
        return $this->hasMany(Billet::class);
    }

    public function pix() {
        return $this->hasMany(Pix::class);
    }

    public function extract() {
        return $this->hasMany(Extract::class);
    }
}
