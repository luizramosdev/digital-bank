<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'uuid',
        'first_name',
        'last_name',
        'date_of_birth',
        'type_document',
        'document',
        'identity_document',
        'mothers_name',
        'genre',
        'phone',
        'mobile',
        'email',
        'password',
        'address_id'
    ];

    // relations
    public function address() {
        return $this->hasOne(Address::class, 'address_id', 'id');
    }

    public function account() {
        return $this->hasOne(Account::class);
    }
}
