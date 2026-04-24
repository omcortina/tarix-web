<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'slug' => 'clasificacion-arancelaria',
                'title' => ['es' => 'Clasificación Arancelaria', 'en' => 'Tariff Classification'],
                'subtitle' => ['es' => 'Determinamos la subpartida arancelaria correcta de tus productos, asegurando el cumplimiento normativo y evitando sanciones.', 'en' => 'We determine the correct tariff classification of your products, ensuring regulatory compliance and avoiding penalties.'],
                'description' => ['es' => 'Determinamos la subpartida arancelaria correcta de tus productos, asegurando el cumplimiento normativo y evitando sanciones.', 'en' => 'We determine the correct tariff classification of your products, ensuring regulatory compliance and avoiding penalties.'],
                'icon_class' => 'icon-classification',
                'what_is_section' => ['es' => '¿Qué es? La clasificación arancelaria es el proceso de asignar un código de arancel a un producto para determinar los aranceles y regulaciones aplicables.', 'en' => 'What is it? Tariff classification is the process of assigning a tariff code to a product to determine applicable duties and regulations.'],
                'process_section' => ['es' => 'Proceso: Análisis del producto → Búsqueda de partida → Validación normativa → Emisión de concepto', 'en' => 'Process: Product analysis → Classification search → Regulatory validation → Concept issuance'],
                'why_section' => ['es' => '¿Por qué es importante? Garantiza el cumplimiento normativo, evita sanciones aduanales y optimiza costos operacionales.', 'en' => 'Why is it important? It ensures regulatory compliance, avoids customs penalties, and optimizes operational costs.'],
                'published' => true,
                'show_in_footer' => true,
            ],
            [
                'slug' => 'valoracion-aduanera',
                'title' => ['es' => 'Valoración Aduanera', 'en' => 'Customs Valuation'],
                'subtitle' => ['es' => 'Asesoría en la determinación del valor en aduana conforme a los métodos internacionales vigentes.', 'en' => 'Advice on determining customs value in accordance with current international methods.'],
                'description' => ['es' => 'Asesoría en la determinación del valor en aduana conforme a los métodos internacionales vigentes.', 'en' => 'Advice on determining customs value in accordance with current international methods.'],
                'icon_class' => 'icon-valuation',
                'what_is_section' => ['es' => '¿Qué es? La valoración aduanera determina el valor tributario de las mercancías para calcular impuestos y aranceles.', 'en' => 'What is it? Customs valuation determines the tax value of goods for calculating taxes and duties.'],
                'process_section' => ['es' => 'Proceso: Recopilación de documentos → Análisis de valores → Aplicación de métodos → Determinación final', 'en' => 'Process: Document collection → Value analysis → Method application → Final determination'],
                'why_section' => ['es' => '¿Por qué es importante? Una valoración correcta evita sanciones y asegura el cálculo justo de tributos.', 'en' => 'Why is it important? Correct valuation avoids penalties and ensures fair tax calculation.'],
                'published' => false,
                'show_in_footer' => false,
            ],
            [
                'slug' => 'origen-mercancías',
                'title' => ['es' => 'Origen de Mercancías', 'en' => 'Merchandise Origin'],
                'subtitle' => ['es' => 'Gestión y trámite de certificados de origen para el aprovechamiento de acuerdos comerciales internacionales.', 'en' => 'Management and processing of certificates of origin to take advantage of international trade agreements.'],
                'description' => ['es' => 'Gestión y trámite de certificados de origen para el aprovechamiento de acuerdos comerciales internacionales.', 'en' => 'Management and processing of certificates of origin to take advantage of international trade agreements.'],
                'icon_class' => 'icon-origin',
                'what_is_section' => ['es' => '¿Qué es? El origen de mercancías determina el país de procedencia y aplica beneficios arancelarios según TLC.', 'en' => 'What is it? Merchandise origin determines the country of origin and applies tariff benefits according to FTA.'],
                'process_section' => ['es' => 'Proceso: Verificación de requisitos → Gestión ante autoridades → Emisión de certificado', 'en' => 'Process: Requirement verification → Management with authorities → Certificate issuance'],
                'why_section' => ['es' => '¿Por qué es importante? Permite acceder a beneficios arancelarios reduciendo costos de importación y exportación.', 'en' => 'Why is it important? It allows access to tariff benefits, reducing import and export costs.'],
                'published' => false,
                'show_in_footer' => false,
            ],
            [
                'slug' => 'asesoría-importaciones',
                'title' => ['es' => 'Asesoría en Importaciones', 'en' => 'Import Consulting'],
                'subtitle' => ['es' => 'Acompañamiento integral en tus operaciones de importación, desde la planificación hasta el desaduanamiento.', 'en' => 'Comprehensive support in your import operations, from planning to customs clearance.'],
                'description' => ['es' => 'Acompañamiento integral en tus operaciones de importación, desde la planificación hasta el desaduanamiento.', 'en' => 'Comprehensive support in your import operations, from planning to customs clearance.'],
                'icon_class' => 'icon-imports',
                'what_is_section' => ['es' => '¿Qué es? Asesoría especializada en procesos de importación con garantía de cumplimiento normativo.', 'en' => 'What is it? Specialized advice on import processes with regulatory compliance guarantee.'],
                'process_section' => ['es' => 'Proceso: Planificación → Gestión documental → Desaduanamiento → Entrega de mercancía', 'en' => 'Process: Planning → Document management → Customs clearance → Merchandise delivery'],
                'why_section' => ['es' => '¿Por qué es importante? Evita retrasos, sanciones y asegura operaciones ágiles y seguras.', 'en' => 'Why is it important? It avoids delays, penalties, and ensures smooth and secure operations.'],
                'published' => true,
                'show_in_footer' => true,
            ],
            [
                'slug' => 'consultoría-comercio-exterior',
                'title' => ['es' => 'Consultoría en Comercio Exterior', 'en' => 'Foreign Trade Consulting'],
                'subtitle' => ['es' => 'Estrategias personalizadas para optimizar tu operación de comercio exterior y reducir costos logísticos.', 'en' => 'Customized strategies to optimize your foreign trade operation and reduce logistics costs.'],
                'description' => ['es' => 'Estrategias personalizadas para optimizar tu operación de comercio exterior y reducir costos logísticos.', 'en' => 'Customized strategies to optimize your foreign trade operation and reduce logistics costs.'],
                'icon_class' => 'icon-consulting',
                'what_is_section' => ['es' => '¿Qué es? Consultoría estratégica en comercio exterior para optimizar procesos y reducir costos.', 'en' => 'What is it? Strategic consulting in foreign trade to optimize processes and reduce costs.'],
                'process_section' => ['es' => 'Proceso: Diagnóstico → Análisis de oportunidades → Propuesta de mejora → Implementación', 'en' => 'Process: Diagnosis → Opportunity analysis → Improvement proposal → Implementation'],
                'why_section' => ['es' => '¿Por qué es importante? Optimiza operaciones internacionales reduciendo costos y mejorando competitividad.', 'en' => 'Why is it important? It optimizes international operations by reducing costs and improving competitiveness.'],
                'published' => true,
                'show_in_footer' => true,
            ],
            [
                'slug' => 'tramites-documentación',
                'title' => ['es' => 'Trámites y Documentación', 'en' => 'Procedures and Documentation'],
                'subtitle' => ['es' => 'Gestión completa de la documentación requerida ante entidades como la DIAN y otras autoridades competentes.', 'en' => 'Complete management of documentation required by entities such as DIAN and other competent authorities.'],
                'description' => ['es' => 'Gestión completa de la documentación requerida ante entidades como la DIAN y otras autoridades competentes.', 'en' => 'Complete management of documentation required by entities such as DIAN and other competent authorities.'],
                'icon_class' => 'icon-procedures',
                'what_is_section' => ['es' => '¿Qué es? Gestión integral de tramitología ante DIAN y autoridades aduanales.', 'en' => 'What is it? Comprehensive management of procedures with DIAN and customs authorities.'],
                'process_section' => ['es' => 'Proceso: Recopilación de documentos → Cumplimiento de requisitos → Trámite ante autoridades', 'en' => 'Process: Document collection → Compliance with requirements → Procedures with authorities'],
                'why_section' => ['es' => '¿Por qué es importante? Asegura el cumplimiento normativo y evita problemas con autoridades.', 'en' => 'Why is it important? It ensures regulatory compliance and avoids problems with authorities.'],
                'published' => false,
                'show_in_footer' => false,
            ],
        ];

        foreach ($services as $service) {
            \App\Models\Service::updateOrCreate(
                ['slug' => $service['slug']],
                $service
            );
        }
    }
}
