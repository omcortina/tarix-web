<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\UsefulResource;
use App\Services\TranslationService;

class UsefulResourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener el primer servicio (Clasificación Arancelaria)
        $service = Service::first();

        if ($service) {
            $resources = [
                [
                    'title' => 'Nomenclatura Común del Mercosur (NCM)',
                    'url' => 'https://www.aduanas.gob.ar/clasificacion-arancelaria',
                    'order' => 1,
                    'is_active' => true,
                ],
                [
                    'title' => 'Sistema Armonizado (SA)',
                    'url' => 'https://www.wcoomd.org/es/temas/nomenclatura-y-clasificacion/instrumentos-y-herramientas/base-de-datos-del-sa.aspx',
                    'order' => 2,
                    'is_active' => true,
                ],
                [
                    'title' => 'Acuerdos Comerciales Vigentes',
                    'url' => 'https://www.mrecic.gov.ar/comercio-exterior/acuerdos-comerciales',
                    'order' => 3,
                    'is_active' => true,
                ],
                [
                    'title' => 'Requisitos por Producto',
                    'url' => 'https://www.aduanas.gob.ar/requisitos-productos',
                    'order' => 4,
                    'is_active' => true,
                ],
            ];

            foreach ($resources as $resource) {
                // Translate title to both ES and EN
                $resource['title'] = TranslationService::makeTranslatable($resource['title']);
                
                UsefulResource::updateOrCreate(
                    [
                        'service_id' => $service->id,
                    ],
                    array_merge(['service_id' => $service->id], $resource)
                );
            }
        }
    }
}
