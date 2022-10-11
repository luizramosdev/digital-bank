<?php

namespace Database\Seeders;

use App\Models\Agency;
use App\Models\Bank;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bank = new Bank();
        $bank->uuid = Str::uuid(10);
        $bank->name = 'Creditech';
        $bank->save();

        $agency = new Agency();
        $agency->uuid = Str::uuid(10);
        $agency->bank_id = $bank->id;
        $agency->number_agency = "001";
        $agency->save();
    }
}
