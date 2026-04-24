/**
 * ArticleMediaManager - Helper para gestionar media de artículos
 * 
 * Uso:
 *   const manager = new ArticleMediaManager(articleId, authToken);
 *   await manager.addImage(url, description);
 *   await manager.addYoutubeVideo(youtubeUrl, description);
 *   await manager.removeMedia(mediaId);
 */

class ArticleMediaManager {
    constructor(articleId, authToken) {
        this.articleId = articleId;
        this.authToken = authToken;
        this.apiBase = '/api/articles';
        
        // Si no hay token, intentar obtenerlo del meta tag
        if (!authToken) {
            const tokenMeta = document.querySelector('meta[name="csrf-token"]');
            this.authToken = tokenMeta?.content || '';
        }
    }

    /**
     * Agregar una imagen desde URL
     */
    async addImage(imageUrl, description = '') {
        return this.addMedia('image', imageUrl, description);
    }

    /**
     * Agregar un video de YouTube
     */
    async addYoutubeVideo(youtubeUrl, description = '') {
        return this.addMedia('youtube', youtubeUrl, description);
    }

    /**
     * Obtener headers predeterminados
     */
    getHeaders(contentType = 'application/json') {
        return {
            'Authorization': `Bearer ${this.authToken}`,
            'Content-Type': contentType,
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
        };
    }

    /**
     * Cargar una imagen desde archivo
     */
    async uploadImage(file, description = '') {
        const formData = new FormData();
        formData.append('type', 'image');
        formData.append('image', file);
        formData.append('description', description);

        try {
            const response = await fetch(
                `${this.apiBase}/${this.articleId}/media`,
                {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    },
                    body: formData,
                }
            );

            if (!response.ok) {
                throw new Error(`Error: ${response.statusText}`);
            }

            return await response.json();
        } catch (error) {
            console.error('Error al cargar imagen:', error);
            throw error;
        }
    }

    /**
     * Agregar media (imagen o video)
     */
    async addMedia(type, url, description = '') {
        try {
            const response = await fetch(
                `${this.apiBase}/${this.articleId}/media`,
                {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    },
                    body: JSON.stringify({
                        type,
                        url,
                        description,
                    }),
                }
            );

            if (!response.ok) {
                const error = await response.json();
                throw new Error(error.message || 'Error al agregar media');
            }

            return await response.json();
        } catch (error) {
            console.error('Error al agregar media:', error);
            throw error;
        }
    }

    /**
     * Obtener todos los media del artículo
     */
    async getMedia() {
        try {
            const response = await fetch(
                `${this.apiBase}/${this.articleId}/media`,
                {
                    credentials: 'same-origin',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    },
                }
            );

            if (!response.ok) {
                throw new Error('Error al obtener media');
            }

            return await response.json();
        } catch (error) {
            console.error('Error al obtener media:', error);
            throw error;
        }
    }

    /**
     * Eliminar un media
     */
    async removeMedia(mediaId) {
        try {
            const response = await fetch(
                `${this.apiBase}/${this.articleId}/media/${mediaId}`,
                {
                    method: 'DELETE',
                    credentials: 'same-origin',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    },
                }
            );

            if (!response.ok) {
                throw new Error('Error al eliminar media');
            }

            return await response.json();
        } catch (error) {
            console.error('Error al eliminar media:', error);
            throw error;
        }
    }

    /**
     * Reordenar media
     */
    async reorderMedia(mediaIds) {
        try {
            const response = await fetch(
                `${this.apiBase}/${this.articleId}/media/reorder`,
                {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    },
                    body: JSON.stringify({
                        media_ids: mediaIds,
                    }),
                }
            );

            if (!response.ok) {
                throw new Error('Error al reordenar media');
            }

            return await response.json();
        } catch (error) {
            console.error('Error al reordenar media:', error);
            throw error;
        }
    }
}

// Exportar para ES modules
if (typeof module !== 'undefined' && module.exports) {
    module.exports = ArticleMediaManager;
}

/**
 * EJEMPLOS DE USO:
 * 
 * // 1. Inicializar
 * const manager = new ArticleMediaManager(1, 'tu-token-aqui');
 * 
 * // 2. Agregar imagen desde URL
 * await manager.addImage(
 *     'https://ejemplo.com/imagen.jpg',
 *     'Mi descripción'
 * );
 * 
 * // 3. Agregar video YouTube
 * await manager.addYoutubeVideo(
 *     'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
 *     'Mi video'
 * );
 * 
 * // 4. Cargar imagen desde archivo
 * const fileInput = document.querySelector('input[type="file"]');
 * await manager.uploadImage(fileInput.files[0], 'Foto cargada');
 * 
 * // 5. Obtener todos los media
 * const media = await manager.getMedia();
 * console.log(media.media);
 * 
 * // 6. Eliminar media
 * await manager.removeMedia(5);
 * 
 * // 7. Reordenar
 * await manager.reorderMedia([3, 1, 2]);
 */
