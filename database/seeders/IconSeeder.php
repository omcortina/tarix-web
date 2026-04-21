<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IconSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $icons = [
            [
                'name' => 'Clasificación Arancelaria',
                'class' => 'icon-classification',
                'label' => 'Clasificación',
                'svg' => '<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="4" y="5" width="16" height="14" rx="2" stroke="currentColor" stroke-width="1.5"/><path d="M8 9L16 9M8 13L13 13M8 17L12 17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>',
            ],
            [
                'name' => 'Valoración Aduanera',
                'class' => 'icon-valuation',
                'label' => 'Valoración',
                'svg' => '<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2Z" stroke="currentColor" stroke-width="1.5"/><path d="M12 5V19M8 9H16M8 15H14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>',
            ],
            [
                'name' => 'Origen de Mercancías',
                'class' => 'icon-origin',
                'label' => 'Origen',
                'svg' => '<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 6C4 4.9 4.9 4 6 4H18C19.1 4 20 4.9 20 6V18C20 19.1 19.1 20 18 20H6C4.9 20 4 19.1 4 18V6Z" stroke="currentColor" stroke-width="1.5"/><path d="M8 10L10.5 12.5L16 7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
            ],
            [
                'name' => 'Asesoría en Importaciones',
                'class' => 'icon-imports',
                'label' => 'Importación',
                'svg' => '<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L4 7V13C4 18 12 22 12 22C12 22 20 18 20 13V7L12 2Z" stroke="currentColor" stroke-width="1.5"/><path d="M12 10L14 12M12 10L10 12M12 10V15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
            ],
            [
                'name' => 'Consultoría en Comercio Exterior',
                'class' => 'icon-consulting',
                'label' => 'Consultoría',
                'svg' => '<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5"/><path d="M8 12C8 15.3 9.8 18 12 18C14.2 18 16 15.3 16 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/><circle cx="9" cy="10" r="0.8" fill="currentColor"/><circle cx="15" cy="10" r="0.8" fill="currentColor"/></svg>',
            ],
            [
                'name' => 'Trámites y Documentación',
                'class' => 'icon-procedures',
                'label' => 'Trámites',
                'svg' => '<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 3H19C20.1 3 21 3.9 21 5V19C21 20.1 20.1 21 19 21H5C3.9 21 3 20.1 3 19V5C3 3.9 3.9 3 5 3Z" stroke="currentColor" stroke-width="1.5"/><path d="M7 8H17M7 12H17M7 16H13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>',
            ],
        ];

        foreach ($icons as $icon) {
            \App\Models\Icon::updateOrCreate(
                ['class' => $icon['class']],
                $icon
            );
        }
    }
}
