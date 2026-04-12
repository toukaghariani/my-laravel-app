<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'     => 'admin',
            'email'    => 'admin@wolfnet.tn',
            'password' => Hash::make('admin'),//not safe on production scale, only for demo testing(env variables better fit)
            //'password' => Hash::make(env('ADMIN_PASSWORD')),  (example here)
            'role'     => 'admin',
            'status'   => 'active',
        ]);
    }
}
