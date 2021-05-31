<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Type;
use App\Models\TypeBank;
use DB;
use Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $create_user = User::create([
            'name' => 'Mochammad Hanif',
            'email' => 'me@hanifz.com',
            'password' => Hash::make('qweqwe123'),
            'role' => 3,
        ]);

        Wallet::create([
            'id_users' => $create_user->id,
        ]);

        Type::create([
            'type' => 'Botol Plastik',
            'price' => 500,
        ]);
        
        TypeBank::create([
            'name' => "BCA",
        ]);

        TypeBank::create([
            'name' => "OVO",
        ]);
    }
}
