<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear empresa Tarix por defecto
        $tarix = Company::firstOrCreate([
            'name' => 'Tarix',
        ], [
            'nit' => 'TARIX-DEFAULT',
            'contact_name' => 'TARIX',
            'contact_email' => 'empresa@tarix.com.co',
            'contact_phone' => null,
            'address' => null,
            'is_active' => true,
        ]);

        // Crear usuario EMPRESA asociado a Tarix
        User::firstOrCreate(
            ['email' => 'empresa@tarix.com.co'],
            [
                'name'        => 'Tarix',
                'user_type'   => 'EMPRESA',
                'company_id'  => $tarix->id,
                'is_verified' => true,
                'verified_at' => now(),
                'password'    => Hash::make('Tarix2026*'),
            ]
        );
    }
}
