<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountSeeder extends Seeder
{
    public $set_schema_table = "accounts";

    public function run()
    {
        $now = Carbon::now();

        DB::table($this->set_schema_table)->insert([
            "uuid" => Str::uuid(10),
            "agency_id" => 1,
            "user_id" => 1,
            "account_number" => rand(9, 99999),
            "balance" => 1000,
            "status" => "ACTIVE",
            "created_at" => $now,
            "updated_at" => $now
        ]);
    }
}
