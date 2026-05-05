<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleMedia;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first() ?? User::create([
            'name' => 'Admin',
            'email' => 'admin@tarix.com',
            'password' => bcrypt('password'),
        ]);

        $article1 = Article::create([
            'title' => ['es' => 'Cómo elegir el mejor servicio de transformación digital', 'en' => 'How to choose the best digital transformation service'],
            'slug' => 'como-elegir-mejor-servicio-transformacion-digital',
            'excerpt' => ['es' => 'Descubre los aspectos clave que debes considerar al seleccionar un socio de transformación digital para tu empresa.', 'en' => 'Discover the key aspects you should consider when selecting a digital transformation partner for your company.'],
            'content' => ['es' => 'La transformación digital es uno de los mayores desafíos de las empresas modernas. No se trata solo de adoptar nuevas tecnologías, sino de cambiar la forma en que tu organización opera.

Cuando busques un servicio de transformación digital, considera estos factores:

1. **Experiencia probada**: Busca empresas con un historial de éxito en proyectos similares al tuyo.

2. **Enfoque integral**: La transformación debe abarcar procesos, tecnología y cultura organizacional.

3. **Soporte continuo**: Asegúrate de que ofrezcan soporte después de la implementación inicial.

4. **Tecnología actualizada**: Verifica que utilicen herramientas y plataformas modernas y relevantes.

5. **ROI claro**: Debe haber métricas definidas para medir el éxito del proyecto.

La transformación digital no es un destino, es un viaje continuo. Elige un socio que entienda esto y esté comprometido con tu éxito a largo plazo.', 'en' => 'Digital transformation is one of the biggest challenges facing modern companies. It\'s not just about adopting new technologies, but about changing the way your organization operates.

When looking for a digital transformation service, consider these factors:

1. **Proven experience**: Look for companies with a track record of success on projects similar to yours.

2. **Holistic approach**: Transformation must span processes, technology, and organizational culture.

3. **Continuous support**: Make sure they offer support after initial implementation.

4. **Updated technology**: Verify they use modern and relevant tools and platforms.

5. **Clear ROI**: There should be defined metrics to measure project success.

Digital transformation is not a destination, it\'s a continuous journey. Choose a partner who understands this and is committed to your long-term success.'],
            'user_id' => $user->id,
            'published' => true,
        ]);

        // Agregar media al artículo 1
        $article1->media()->createMany([
            [
                'type' => 'image',
                'url' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?w=800',
                'description' => ['es' => 'Transformación digital en acción', 'en' => 'Digital transformation in action'],
                'order' => 1,
            ],
            [
                'type' => 'youtube',
                'url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'description' => ['es' => 'Video introductorio sobre transformación', 'en' => 'Introductory video on transformation'],
                'order' => 2,
            ],
        ]);

        $article2 = Article::create([
            'title' => ['es' => 'Tendencias tecnológicas para 2026', 'en' => 'Technology trends for 2026'],
            'slug' => 'tendencias-tecnologicas-2026',
            'excerpt' => ['es' => 'Explora las tendencias tecnológicas más importantes que definirán el panorama empresarial en 2026.', 'en' => 'Explore the most important technology trends that will shape the business landscape in 2026.'],
            'content' => ['es' => 'El año 2026 promete ser emocionante en el mundo de la tecnología. Aquí te presentamos las tendencias que debes estar atento:

**Inteligencia Artificial Generativa**
La IA generativa seguirá revolucionando la forma en que trabajamos. Desde automatización de procesos hasta generación de contenido, las aplicaciones son prácticamente ilimitadas.

**Cloud Computing Avanzado**
La adopción de soluciones en la nube continúa creciendo. Las empresas buscan mayor flexibilidad, escalabilidad y eficiencia de costos.

**Seguridad Cibernética Reforzada**
Con más datos en línea que nunca, la seguridad es crítica. Esperamos ver inversiones significativas en protección de datos.

**IoT (Internet de las Cosas)**
Dispositivos conectados e inteligentes seguirán proliferando en todos los sectores industriales.

**Computación Cuántica**
Aunque aún está en desarrollo, la computación cuántica comenzará a mostrar aplicaciones prácticas en ciertos dominios.

La clave para prosperar en 2026 es mantenerse informado y adaptarse rápidamente a estos cambios.', 'en' => 'The year 2026 promises to be exciting in the world of technology. Here are the trends you should watch:

**Generative Artificial Intelligence**
Generative AI will continue to revolutionize the way we work. From process automation to content generation, applications are practically unlimited.

**Advanced Cloud Computing**
Adoption of cloud solutions continues to grow. Companies seek greater flexibility, scalability, and cost efficiency.

**Enhanced Cybersecurity**
With more data online than ever, security is critical. We expect to see significant investments in data protection.

**IoT (Internet of Things)**
Connected and intelligent devices will continue to proliferate across all industrial sectors.

**Quantum Computing**
While still in development, quantum computing will begin to show practical applications in certain domains.

The key to thriving in 2026 is staying informed and adapting quickly to these changes.'],
            'user_id' => $user->id,
            'published' => true,
        ]);

        // Agregar media al artículo 2
        $article2->media()->createMany([
            [
                'type' => 'image',
                'url' => 'https://images.unsplash.com/photo-1677442d019cecf8a0538e14dd277bfc566d34485?w=800',
                'description' => ['es' => 'Tendencias de IA', 'en' => 'AI Trends'],
                'order' => 1,
            ],
            [
                'type' => 'image',
                'url' => 'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?w=800',
                'description' => ['es' => 'Cloud Computing', 'en' => 'Cloud Computing'],
                'order' => 2,
            ],
        ]);

        $article3 = Article::create([
            'title' => ['es' => 'Guía completa de transformación en la nube', 'en' => 'Complete cloud transformation guide'],
            'slug' => 'guia-transformacion-nube',
            'excerpt' => ['es' => 'Todo lo que necesitas saber para migrar tu infraestructura a la nube de manera segura y eficiente.', 'en' => 'Everything you need to know to migrate your infrastructure to the cloud safely and efficiently.'],
            'content' => ['es' => 'La migración a la nube es una decisión estratégica importante. Esta guía te ayudará a navegar el proceso.

**Fase 1: Evaluación**
Antes de migrar, evalúa tu infraestructura actual. Identifica aplicaciones que son fáciles de migrar y aquellas que requieren más atención.

**Fase 2: Planificación**
Desarrolla un plan detallado. Define cronogramas, asigna recursos y establece métricas de éxito.

**Fase 3: Preparación**
Capacita a tu equipo. Asegúrate de que todos entiendan las nuevas herramientas y procesos.

**Fase 4: Migración**
Comienza con un enfoque gradual. Migra aplicaciones de baja criticidad primero para ganar experiencia.

**Fase 5: Optimización**
Una vez en la nube, optimiza continuamente. Revisa costos, rendimiento y seguridad regularmente.

**Mejores Prácticas**
- Nunca migres todo de una vez
- Realiza pruebas extensas antes de migrar datos críticos
- Mantén copias de seguridad de tu infraestructura anterior
- Monitorea constantemente el rendimiento

La nube no es una solución mágica, pero cuando se implementa correctamente, puede transformar tu negocio.', 'en' => 'Cloud migration is an important strategic decision. This guide will help you navigate the process.

**Phase 1: Evaluation**
Before migrating, evaluate your current infrastructure. Identify applications that are easy to migrate and those that require more attention.

**Phase 2: Planning**
Develop a detailed plan. Define timelines, allocate resources, and establish success metrics.

**Phase 3: Preparation**
Train your team. Make sure everyone understands the new tools and processes.

**Phase 4: Migration**
Start with a gradual approach. Migrate low-criticality applications first to gain experience.

**Phase 5: Optimization**
Once in the cloud, continuously optimize. Regularly review costs, performance, and security.

**Best Practices**
- Never migrate everything at once
- Perform extensive testing before migrating critical data
- Keep backups of your previous infrastructure
- Continuously monitor performance

The cloud is not a magic solution, but when implemented correctly, it can transform your business.'],
            'user_id' => $user->id,
            'published' => true,
        ]);

        // Agregar media al artículo 3
        $article3->media()->createMany([
            [
                'type' => 'youtube',
                'url' => 'https://www.youtube.com/watch?v=jNQXAC9IVRw',
                'description' => ['es' => 'Guía de migración a la nube', 'en' => 'Cloud migration guide'],
                'order' => 1,
            ],
        ]);

        // Crear 22 artículos adicionales para demostración de paginación
        $topics = [
            ['es' => 'Seguridad en el comercio electrónico', 'en' => 'Security in e-commerce'],
            ['es' => 'Automatización de procesos empresariales', 'en' => 'Business process automation'],
            ['es' => 'Análisis de datos con Machine Learning', 'en' => 'Data analysis with Machine Learning'],
            ['es' => 'Gestión de proyectos en equipo', 'en' => 'Team project management'],
            ['es' => 'Desarrollos ágiles: metodología Scrum', 'en' => 'Agile development: Scrum methodology'],
            ['es' => 'Diseño UX/UI para aplicaciones modernas', 'en' => 'UX/UI design for modern applications'],
            ['es' => 'API REST: mejores prácticas', 'en' => 'REST API: best practices'],
            ['es' => 'Contenedores Docker: introducción práctica', 'en' => 'Docker containers: practical introduction'],
            ['es' => 'Microservicios en arquitectura moderna', 'en' => 'Microservices in modern architecture'],
            ['es' => 'DevOps: cultura y herramientas', 'en' => 'DevOps: culture and tools'],
            ['es' => 'Blockchain y sus aplicaciones empresariales', 'en' => 'Blockchain and business applications'],
            ['es' => 'Realidad aumentada en el retail', 'en' => 'Augmented reality in retail'],
            ['es' => 'Big Data: recolección y análisis', 'en' => 'Big Data: collection and analysis'],
            ['es' => 'Sostenibilidad digital en la empresa', 'en' => 'Digital sustainability in business'],
            ['es' => 'Ciberseguridad: riesgos y soluciones', 'en' => 'Cybersecurity: risks and solutions'],
            ['es' => 'Inteligencia de negocios (BI)', 'en' => 'Business Intelligence (BI)'],
            ['es' => 'Transformación digital en PYMES', 'en' => 'Digital transformation in SMEs'],
            ['es' => 'Gestión de identidad digital', 'en' => 'Digital identity management'],
            ['es' => 'Redes 5G: impacto en negocios', 'en' => '5G networks: business impact'],
            ['es' => 'Computación en el extremo (Edge Computing)', 'en' => 'Edge Computing'],
            ['es' => 'Sostenibilidad y economía circular', 'en' => 'Sustainability and circular economy'],
            ['es' => 'Experiencia del cliente en tiempos digitales', 'en' => 'Customer experience in digital times'],
        ];

        foreach ($topics as $index => $titles) {
            $slug = strtolower(str_replace(' ', '-', $titles['es']));
            $published = true; // Todos publicados

            Article::create([
                'title' => ['es' => $titles['es'], 'en' => $titles['en']],
                'slug' => $slug,
                'excerpt' => [
                    'es' => 'Artículo sobre ' . lcfirst($titles['es']) . '. Descubre los conceptos principales y mejores prácticas en este campo.',
                    'en' => 'Article about ' . lcfirst($titles['en']) . '. Discover the main concepts and best practices in this field.'
                ],
                'content' => [
                    'es' => 'Este es un artículo de demostración sobre ' . lcfirst($titles['es']) . '. 

En el mundo actual, este tema es cada vez más relevante para las empresas que buscan mantenerse competitivas en el mercado digital.

**Aspectos clave:**
1. Innovación continua en el sector
2. Adopción de nuevas herramientas y tecnologías
3. Capacitación del equipo
4. Estrategia integral de implementación

La transformación es un proceso gradual que requiere compromiso y dedicación. Para más información, consulta con expertos en la materia.',
                    'en' => 'This is a demonstration article about ' . lcfirst($titles['en']) . '.

In today\'s world, this topic is increasingly relevant for companies looking to remain competitive in the digital market.

**Key aspects:**
1. Continuous innovation in the sector
2. Adoption of new tools and technologies
3. Team training
4. Comprehensive implementation strategy

Transformation is a gradual process that requires commitment and dedication. For more information, consult with subject matter experts.'
                ],
                'user_id' => $user->id,
                'published' => $published,
            ]);
        }
    }
}
