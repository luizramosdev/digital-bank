<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Account;
use App\Models\Address;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public $set_schema_table = "users";

    public function run()
    {
        $now = Carbon::now();
        DB::table($this->set_schema_table)->insert([
            "uuid" => Str::uuid(10),
            "first_name" => "Joao",
            "last_name" => "Silva",
            "date_of_birth" => "2000-02-08",
            "type_document" => "CPF",
            "document" => "21309803412",
            "identity_document" => "289190873",
            "mothers_name" => "Maria da Silva",
            "genre" => "MALE",
            "phone" => "1932164996",
            "mobile" => "19981973462",
            "email" => 'joao@teste.com',
            "password" => Hash::make('123456'),
            "address_id" => 1,
            "created_at" => $now,
            "updated_at" => $now
        ]);
    }
}
