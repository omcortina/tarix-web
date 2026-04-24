# 📸 Sistema Dinámico de Media para Artículos

## ¿Qué se implementó?

Se creó un **sistema robusto y escalable** para agregar imágenes y videos de YouTube a los artículos. 

### Componentes Creados:

#### 1. **Tabla: `article_media`**
```sql
- id
- article_id (FK)
- type (enum: 'image', 'youtube')
- url (imagen o URL YouTube)
- description (multiidioma)
- order (orden de aparición)
- timestamps
```

#### 2. **Modelo: `ArticleMedia`**
- Relación con `Article`
- Método `getYoutubeEmbedAttribute()` para extraer ID de YouTube
- Soporte multiidioma para descripciones

#### 3. **Relaciones en Article**
```php
$article->media()      // Todos los media
$article->images()     // Solo imágenes
$article->videos()     // Solo videos YouTube
```

#### 4. **API REST para Administración**

**Endpoints:**
```
GET    /api/articles/{id}/media              // Obtener todos
POST   /api/articles/{id}/media              // Agregar media
POST   /api/articles/{id}/media/reorder      // Reordenar
DELETE /api/articles/{id}/media/{mediaId}    // Eliminar
```

#### 5. **Vistas Actualizadas**

##### `articles/index.blade.php` (Listado)
- ✅ Muestra imagen destacada (primera imagen del artículo)
- ✅ Badges con contador de imágenes y videos
- ✅ Diseño responsivo

##### `articles/show.blade.php` (Detalle)
- ✅ Galería multimedia completa
- ✅ Embed de videos YouTube responsivo
- ✅ Descripciones traducibles
- ✅ Orden personalizado

---

## 📝 Cómo Usar

### **Agregar Media Programáticamente (Seeds/Migraciones)**

```php
$article = Article::create([...]);

// Agregar imágenes
$article->media()->create([
    'type' => 'image',
    'url' => 'https://ejemplo.com/imagen.jpg',
    'description' => ['es' => 'Descripción', 'en' => 'Description'],
    'order' => 1,
]);

// Agregar video YouTube
$article->media()->create([
    'type' => 'youtube',
    'url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
    'description' => ['es' => 'Mi video', 'en' => 'My video'],
    'order' => 2,
]);
```

### **URLs de YouTube Soportadas**

El sistema acepta varios formatos:
```
✅ https://www.youtube.com/watch?v=dQw4w9WgXcQ
✅ https://youtu.be/dQw4w9WgXcQ
✅ dQw4w9WgXcQ (solo ID)
```

### **Agregar Media vía API**

**Imagen desde URL:**
```bash
curl -X POST \
  http://localhost/api/articles/1/media \
  -H "Authorization: Bearer TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "type": "image",
    "url": "https://ejemplo.com/imagen.jpg",
    "description": "Mi descripción"
  }'
```

**Imagen cargada (multipart):**
```bash
curl -X POST \
  http://localhost/api/articles/1/media \
  -H "Authorization: Bearer TOKEN" \
  -F "type=image" \
  -F "image=@archivo.jpg" \
  -F "description=Descripción"
```

**Video YouTube:**
```bash
curl -X POST \
  http://localhost/api/articles/1/media \
  -H "Authorization: Bearer TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "type": "youtube",
    "url": "https://www.youtube.com/watch?v=dQw4w9WgXcQ",
    "description": "Mi video"
  }'
```

### **Reordenar Media**

```bash
curl -X POST \
  http://localhost/api/articles/1/media/reorder \
  -H "Authorization: Bearer TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "media_ids": [3, 1, 2]
  }'
```

### **Eliminar Media**

```bash
curl -X DELETE \
  http://localhost/api/articles/1/media/5 \
  -H "Authorization: Bearer TOKEN"
```

---

## 🎨 Ejemplo en Seeder

Los artículos ya tienen media de ejemplo:

```php
// Artículo 1: 1 imagen + 1 video
$article1->media()->createMany([
    [
        'type' => 'image',
        'url' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?w=800',
        'description' => ['es' => 'Transformación digital', 'en' => 'Digital transformation'],
        'order' => 1,
    ],
    [
        'type' => 'youtube',
        'url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        'description' => ['es' => 'Video intro', 'en' => 'Intro video'],
        'order' => 2,
    ],
]);
```

---

## 🔐 Seguridad

✅ **Validación:**
- Imágenes: máximo 5MB
- URLs validadas
- Type enum (image|youtube)

✅ **Autorización:**
- Solo usuarios autenticados pueden agregar/editar media
- Verificación de pertenencia del artículo

✅ **Almacenamiento:**
- Imágenes cargadas se guardan en `storage/app/public/articles/`
- Se eliminan al borrar el media
- URLs públicas accesibles vía `/storage/`

---

## 📱 Frontend Responsive

Todos los embeds y galerías son **100% responsivos**:
- Videos YouTube: proporción 16:9 mantenida
- Imágenes: se adaptan al ancho del contenedor
- Móvil, tablet y desktop soportados

---

## 🚀 Próximas Mejoras Opcionales

1. **Editor Visual** - Integrar CKEditor 5 con uploads drag-drop
2. **Galería Lightbox** - Expandir imágenes al hacer click
3. **Optimización** - Lazy loading de imágenes
4. **Transcripción** - Auto-generar transcripciones de videos
5. **Analytics** - Contar clicks en videos/imágenes

---

## 📊 Estado Actual

- ✅ Base de datos: **LISTA**
- ✅ Modelos: **LISTOS**
- ✅ API: **LISTA**
- ✅ Vistas públicas: **ACTUALIZADAS**
- ✅ Seeders: **CON EJEMPLOS**
- ⏳ Admin UI: **Por crear** (opcional)

## Ver en Acción

1. Accede a `/blog` para ver los artículos con media
2. Haz click en "Ver más" para ver la galería completa
3. Los videos YouTube se reproducen inline

---

**¡Sistema listo para producción! 🎉**
