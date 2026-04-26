<?php

namespace Database\Seeders;

use App\Models\Value;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Valor 1: Precisión
        Value::create([
            'name' => [
                'es' => 'Precisión arancelaria',
                'en' => 'Tariff precision',
            ],
            'description' => [
                'es' => 'Nos enfocamos en la exactitud técnica para determinar la subpartida correcta y evitar errores, sanciones y sobrecostos.',
                'en' => 'We focus on technical accuracy to determine the correct subheading and avoid errors, penalties and overcharges.',
            ],
            'icon_svg' => '<circle cx="12" cy="12" r="9" stroke="white" stroke-width="1.6"/><circle cx="12" cy="12" r="5" stroke="white" stroke-width="1.4"/><circle cx="12" cy="12" r="2" fill="white"/><path d="M12 3v2M12 19v2M3 12h2M19 12h2" stroke="white" stroke-width="1.4" stroke-linecap="round"/>',
            'icon_color' => '#2a9d8f',
            'order' => 1,
            'is_active' => true,
        ]);

        // Valor 2: Seguridad
        Value::create([
            'name' => [
                'es' => 'Seguridad y cumplimiento',
                'en' => 'Security and compliance',
            ],
            'description' => [
                'es' => 'Cumplimos con la normativa vigente y los más altos estándares para proteger tu operación ante la DIAN y demás entidades.',
                'en' => 'We comply with current regulations and the highest standards to protect your operation with the DIAN and other entities.',
            ],
            'icon_svg' => '<path d="M12 2L4 5.5V11C4 17 12 22 12 22S20 17 20 11V5.5L12 2Z" stroke="white" stroke-width="1.6" stroke-linejoin="round"/><path d="M9 12l2 2 4-4" stroke="white" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>',
            'icon_color' => '#e05252',
            'order' => 2,
            'is_active' => true,
        ]);

        // Valor 3: Eficiencia
        Value::create([
            'name' => [
                'es' => 'Eficiencia y optimización',
                'en' => 'Efficiency and optimization',
            ],
            'description' => [
                'es' => 'Buscamos las mejores alternativas para optimizar costos, tiempos y recursos en tus procesos de importación.',
                'en' => 'We seek the best alternatives to optimize costs, times and resources in your import processes.',
            ],
            'icon_svg' => '<circle cx="12" cy="12" r="9" stroke="white" stroke-width="1.6"/><path d="M12 6v12" stroke="white" stroke-width="1.6" stroke-linecap="round"/><path d="M15 8.5C15 7.4 13.7 6.5 12 6.5S9 7.4 9 8.5C9 9.6 10 10 12 10.3C14 10.6 15 11.2 15 12.5C15 13.8 13.7 14.5 12 14.5S9 13.7 9 12.5" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>',
            'icon_color' => '#2176ae',
            'order' => 3,
            'is_active' => true,
        ]);
    }
}
