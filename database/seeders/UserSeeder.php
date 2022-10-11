<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\User;
use App\Models\Address;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $address = new Address();
        $address->uuid = Str::uuid(10);
        $address->zip_code = '13082613';
        $address->street = 'Antonio Guilherme R Ribas';
        $address->number = '52';
        $address->complement = 'Casa';
        $address->neighborhood = 'Vila Esperança';
        $address->city = 'Campinas';
        $address->state = 'SP';
        $address->save();

        $user = new User();
        $user->uuid = Str::uuid(10);
        $user->first_name = 'Joao';
        $user->last_name = 'Silva';
        $user->date_of_birth = '2000-02-08';
        $user->type_document = 'CPF';
        $user->document = '21309803412';
        $user->identity_document = '289190873';
        $user->mothers_name = 'Maria da Silva';
        $user->phone = '1932164996';
        $user->mobile = '19981973462';
        $user->email = 'joao@teste.com';
        $user->password = Hash::make('123456');
        $user->address_id = $address->id;
        $user->save();

        $account = new Account();
        $account->uuid = Str::uuid(10);
        $account->agency_id = '1';
        $account->user_id = $user->id;
        $account->account_number = rand(0, 99999);
        $account->balance = 10000;
        $account->status = 'ACTIVE';
        $account->save();
    }
}
