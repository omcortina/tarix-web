<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;

class UpdateServicesFooterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Marcar los primeros 3 servicios para que aparezcan en el footer
        Service::take(3)->update(['show_in_footer' => true]);
    }
}
