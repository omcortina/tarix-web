# 📝 Guía de Uso: Admin Panel de Artículos con Media

## ¿Cómo funciona?

Al crear o editar un artículo en el panel admin, ahora tienes una sección **"📸 Galería Multimedia"** donde puedes:

1. ✅ Agregar imágenes desde URL
2. ✅ Agregar videos de YouTube
3. ✅ Ver previsualización de todos los media agregados
4. ✅ Eliminar media individual

---

## 🎯 Paso a Paso

### **1. Acceder al panel admin**
```
Dashboard → Artículos → Crear Nuevo / Editar
```

### **2. Completar datos del artículo**
- Título (requerido)
- Resumen (opcional)
- Contenido (requerido)

### **3. Agregar Media (Solo al Editar)**

> **Importante:** La galería multimedia solo aparece cuando **editas un artículo ya creado**. 
> Primero crea/guarda el artículo, luego edítalo para agregar media.

#### **Agregar Imagen desde URL**
```
1. Pega la URL completa en el campo "URL de Imagen"
2. Deja vacío el campo de YouTube
3. Haz click en "+ Agregar"
4. Verás la miniatura en la galería
```

**URLs Soportadas:**
- `https://images.unsplash.com/photo-xxx?w=800`
- `https://ejemplo.com/mi-imagen.jpg`
- Cualquier URL directa a imagen (JPG, PNG, WebP, etc.)

#### **Agregar Video YouTube**
```
1. Pega la URL en el campo "URL de YouTube"
2. Deja vacío el campo de Imagen
3. Haz click en "+ Agregar"
4. Verás el ícono de play en la galería
```

**URLs Soportadas:**
- `https://www.youtube.com/watch?v=dQw4w9WgXcQ`
- `https://youtu.be/dQw4w9WgXcQ`
- `dQw4w9WgXcQ` (solo ID)

### **4. Eliminar Media**
```
1. Localizalo en la galería
2. Haz click en botón "Eliminar"
3. Confirma la acción
```

---

## 🎨 Ejemplo Visual

### Panel Admin Artículos
```
┌─────────────────────────────────────┐
│ Nuevo Artículo                      │
├─────────────────────────────────────┤
│ Título: [Cómo elegir...            │
│ Resumen: [Descubre los aspectos...]│
│ Contenido: [La transformación...]  │
│                                     │
│ 📸 Galería Multimedia               │
│ ┌──────────────┬──────────────┐    │
│ │ 🖼️ Imagen    │ 🎬 Video     │    │
│ │ Minatura     │ YouTube      │    │
│ │ [Eliminar]   │ [Eliminar]   │    │
│ └──────────────┴──────────────┘    │
│                                     │
│ Agregar Media                       │
│ [https://...] [https://...] [+Agregar]
│                                     │
│ [Cancelar] [Actualizar]            │
└─────────────────────────────────────┘
```

---

## ⚠️ Tips Importantes

### ✅ Hacer
- ✔️ Usar URLs HTTPS (no HTTP)
- ✔️ Verificar que la imagen sea accesible en el navegador antes
- ✔️ Usar URLs directas (terminadas en .jpg, .png, etc)
- ✔️ Borrar campos antes de agregar nuevo tipo de media

### ❌ No Hacer
- ❌ Rellenar ambos campos (imagen Y YouTube) al mismo tiempo
- ❌ Pegar URLs de galerías o directorios
- ❌ Dejar campos vacíos y hacer click en "+ Agregar"
- ❌ Usar imágenes protegidas/privadas

---

## 🔗 Dónde se Muestra el Media

### Vista Pública - Listado de Artículos (`/blog`)
```
[Imagen destacada]
Título del artículo
Resumen...
[🖼️ 1 imagen(es)]  [🎬 1 video(s)]
[Leer más →]
```

### Vista Pública - Detalle (`/blog/titulo-articulo`)
```
# Título del Artículo
Por Admin | 23 de Abril de 2026

Contenido del artículo...

## Galería Multimedia
[Imagen 1 grande]
[Imagen 2 grande]
[Video YouTube embebido - 16:9]

## Artículos Relacionados
[Card 1] [Card 2] [Card 3]
```

---

## 🚨 Problemas Comunes

### "Error: Media agregado exitosamente" pero no aparece
**Solución:**
1. Recarga la página
2. Verifica que esté conectado
3. Prueba nuevamente

### Imagen no se carga
**Solución:**
1. Verifica que la URL sea correcta y accesible
2. Usa URL HTTPS
3. Asegúrate de que la imagen no sea privada

### YouTube no reproduce
**Solución:**
1. Verifica que sea la URL completa
2. Usa: `https://www.youtube.com/watch?v=...`
3. Evita versiones acortadas/modificadas

---

## 🔄 Flujo Completo

1. **Crear artículo** con título, resumen, contenido
2. **Guardar artículo** (click Publicar)
3. **Editar artículo** (desde listado de artículos)
4. **Agregar media** en la sección "📸 Galería Multimedia"
5. **Guardar cambios** (click Actualizar)
6. **Ver en público** en `/blog`

---

## 📊 Límites

- **Tamaño imagen:** URL de cualquier tamaño
- **Cantidad media:** Sin límite
- **Tipos soportados:** 
  - Imágenes: JPG, PNG, WebP, GIF
  - Videos: Solo YouTube

---

## 💡 Pro Tips

### Obtener URLs de imágenes
- **Unsplash:** `https://images.unsplash.com/photo-xxx?w=800`
- **Pexels:** Copiar URL de descarga
- **Tu servidor:** `https://ejemplo.com/images/foto.jpg`

### Extraer ID de YouTube
- URL: `https://www.youtube.com/watch?v=dQw4w9WgXcQ`
- ID: `dQw4w9WgXcQ` (después de `v=`)

### URLs Cortas de YouTube
Si tienes: `https://youtu.be/dQw4w9WgXcQ`
Sistema automáticamente extrae: `dQw4w9WgXcQ`

---

**¡Listo! Ya puedes crear artículos dinámicos con imágenes y videos. 🚀**
