<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Bank;
use App\Models\Agency;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BankSeeder extends Seeder
{
    public $set_schema_table = "banks";

    public function run()
    {
        $now = Carbon::now();

        DB::table($this->set_schema_table)->insert([
            "uuid" => Str::uuid(10),
            "name" => "Creditech",
            "created_at" => $now,
            "updated_at" => $now
        ]);
    }
}
