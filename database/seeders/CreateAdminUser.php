<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreateAdminUser extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new \App\Models\User();
        $user->name = 'Admin TARIX';
        $user->email = 'admin@tarix.com.co';
        $user->password = \Illuminate\Support\Facades\Hash::make('admin123');
        $user->user_type = 'ADMIN';
        $user->save();

        $user = new \App\Models\User();
        $user->name = 'Jeison Ruiz';
        $user->email = 'admin2@tarix.com.co';
        $user->password = \Illuminate\Support\Facades\Hash::make('admin123');
        $user->user_type = 'ADMIN';
        $user->save();
    }
}
