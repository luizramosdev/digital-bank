<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddressSeeder extends Seeder
{
    public $set_schema_table = 'addresses';

    public function run()
    {
        $now = Carbon::now();

        DB::table($this->set_schema_table)->insert([
            "uuid" => Str::uuid(10),
            "zip_code" => "50960420",
            "street" => "Rua Eduardo Prado",
            "number" => "732",
            "complement" => "Casa",
            "neighborhood" => "Várzea",
            "city" => "Recife",
            "state" => "PE",
            "created_at" => $now,
            "updated_at" => $now
        ]);
    }
}
