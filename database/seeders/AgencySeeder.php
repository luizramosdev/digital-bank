<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgencySeeder extends Seeder
{
    public $set_schema_table = "agencies";

    public function run()
    {
        $now = Carbon::now();

        DB::table($this->set_schema_table)->insert([
            "uuid" => Str::uuid(10),
            "bank_id" => 1,
            "number_agency" => "001",
            "created_at" => $now,
            "updated_at" => $now
        ]);
    }
}
