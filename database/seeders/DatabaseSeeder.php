<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        // Buat data pengguna MongoDB
        $user = new \App\Models\User();
        $user->name = 'Fanimu';
        $user->email = 'fanimu7@gmail.com';
        $user->password = Hash::make('admin');
        $user->save();
    }
}
