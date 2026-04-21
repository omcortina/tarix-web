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
        $user->email = 'admin@tarix.com';
        $user->password = \Illuminate\Support\Facades\Hash::make('admin123');
        $user->save();
    }
}
