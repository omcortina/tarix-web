<!-- SECCIÓN DE CONTACTO -->
<section id="contacto" class="contact-section">
    <div class="contact-container">
        <h2>¿Necesitas Ayuda?</h2>
        <p>Contáctanos para consultas sobre nuestros servicios de comercio exterior</p>
        
        <form id="contactForm" class="contact-form">
            @csrf
            
            <div class="form-group">
                <label for="name">Nombre completo *</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    placeholder="Tu nombre" 
                    required
                    class="form-input"
                >
                <span class="form-error" id="nameError"></span>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="email">Correo electrónico *</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        placeholder="tu@email.com" 
                        required
                        class="form-input"
                    >
                    <span class="form-error" id="emailError"></span>
                </div>

                <div class="form-group">
                    <label for="phone">Teléfono</label>
                    <input 
                        type="tel" 
                        id="phone" 
                        name="phone" 
                        placeholder="+57 300 000 0000"
                        class="form-input"
                    >
                </div>
            </div>

            <div class="form-group">
                <label for="company">Empresa/Razón social</label>
                <input 
                    type="text" 
                    id="company" 
                    name="company" 
                    placeholder="Nombre de tu empresa"
                    class="form-input"
                >
            </div>

            <div class="form-group">
                <label for="message">Mensaje *</label>
                <textarea 
                    id="message" 
                    name="message" 
                    placeholder="Cuéntanos cómo podemos ayudarte..." 
                    rows="5"
                    required
                    class="form-input"
                ></textarea>
                <span class="form-error" id="messageError"></span>
            </div>

            <!-- reCAPTCHA v3 (invisible) -->
            <input 
                type="hidden" 
                id="g-recaptcha-response" 
                name="g-recaptcha-response"
            >

            <div class="form-group form-submit">
                <button type="submit" class="btn-primary btn-large" id="submitBtn">
                    Enviar Consulta
                </button>
                <div class="recaptcha-notice">
                    Este sitio está protegido por reCAPTCHA y aplican la 
                    <a href="https://policies.google.com/privacy" target="_blank">Política de Privacidad</a> y 
                    <a href="https://policies.google.com/terms" target="_blank">Términos de Servicio</a> de Google.
                </div>
            </div>

            <!-- Mensajes de estado -->
            <div id="successMessage" class="alert alert-success" style="display:none;">
                ¡Consulta enviada exitosamente! Nos pondremos en contacto pronto.
            </div>
            <div id="errorMessage" class="alert alert-error" style="display:none;"></div>
        </form>
    </div>
</section>

<!-- Estilos -->
<style>
    .contact-section {
        padding: 60px 20px;
        background: linear-gradient(135deg, #f5f7fa 0%, #ffffff 100%);
        margin-top: 60px;
    }

    .contact-container {
        max-width: 600px;
        margin: 0 auto;
    }

    .contact-section h2 {
        font-family: 'Montserrat', sans-serif;
        font-size: 28px;
        font-weight: 700;
        color: #0d2340;
        text-align: center;
        margin-bottom: 10px;
    }

    .contact-section > p {
        text-align: center;
        color: #666;
        margin-bottom: 30px;
        font-size: 16px;
    }

    .contact-form {
        background: white;
        padding: 40px;
        border-radius: 8px;
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        color: #0d2340;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .form-input {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
        font-family: 'Inter', sans-serif;
        transition: border-color 0.3s, box-shadow 0.3s;
    }

    .form-input:focus {
        outline: none;
        border-color: #1ba8a0;
        box-shadow: 0 0 0 3px rgba(27, 168, 160, 0.1);
    }

    .form-input:invalid:not(:placeholder-shown) {
        border-color: #ff6b6b;
    }

    textarea.form-input {
        resize: vertical;
        font-family: 'Inter', sans-serif;
    }

    .form-error {
        display: block;
        color: #ff6b6b;
        font-size: 12px;
        margin-top: 4px;
        min-height: 16px;
    }

    .form-submit {
        margin-top: 30px;
    }

    .btn-large {
        width: 100%;
        padding: 14px 24px;
        font-size: 16px;
        font-weight: 600;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s;
        background-color: #1ba8a0;
        color: white;
    }

    .btn-large:hover {
        background-color: #158f87;
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(27, 168, 160, 0.3);
    }

    .btn-large:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .recaptcha-notice {
        font-size: 12px;
        color: #999;
        margin-top: 15px;
        text-align: center;
        line-height: 1.4;
    }

    .recaptcha-notice a {
        color: #1ba8a0;
        text-decoration: none;
    }

    .recaptcha-notice a:hover {
        text-decoration: underline;
    }

    .alert {
        padding: 15px 20px;
        border-radius: 6px;
        margin-top: 20px;
        font-weight: 500;
    }

    .alert-success {
        background-color: #E8F5E9;
        color: #2e7d32;
        border-left: 4px solid #4caf50;
    }

    .alert-error {
        background-color: #FFEBEE;
        color: #c62828;
        border-left: 4px solid #f44336;
    }

    @media (max-width: 640px) {
        .contact-form {
            padding: 30px 20px;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .contact-section h2 {
            font-size: 24px;
        }
    }
</style>

<!-- Script reCAPTCHA v3 -->
<script src="https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHA_SITE_KEY') }}"></script>

<!-- Script del formulario -->
<script>
    const contactForm = document.getElementById('contactForm');
    const submitBtn = document.getElementById('submitBtn');
    const successMessage = document.getElementById('successMessage');
    const errorMessage = document.getElementById('errorMessage');

    // Ejecutar reCAPTCHA v3 cuando el usuario intenta enviar
    contactForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        // Ejecutar reCAPTCHA
        grecaptcha.ready(() => {
            grecaptcha.execute('{{ env("RECAPTCHA_SITE_KEY") }}', { action: 'submit' })
                .then(token => {
                    document.getElementById('g-recaptcha-response').value = token;
                    enviarFormulario();
                })
                .catch(error => {
                    console.error('reCAPTCHA error:', error);
                    mostrarError('Error con reCAPTCHA. Por favor, recarga la página e intenta nuevamente.');
                });
        });
    });

    function enviarFormulario() {
        // Validar cliente
        if (!validarFormulario()) {
            return;
        }

        // Deshabilitar botón
        submitBtn.disabled = true;
        submitBtn.textContent = 'Enviando...';

        const formData = new FormData(contactForm);

        fetch('{{ route("contact.store") }}', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                mostrarExito(data.message);
                contactForm.reset();
                limpiarErrores();
            } else {
                mostrarError(data.message || 'Ocurrió un error. Intenta nuevamente.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarError('Error de conexión. Por favor, intenta más tarde.');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Enviar Consulta';
        });
    }

    function validarFormulario() {
        const name = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        const message = document.getElementById('message').value.trim();

        limpiarErrores();
        let esValido = true;

        if (!name) {
            mostrarErrorCampo('name', 'El nombre es requerido');
            esValido = false;
        }

        if (!email || !isValidEmail(email)) {
            mostrarErrorCampo('email', 'Ingresa un email válido');
            esValido = false;
        }

        if (message.length < 10) {
            mostrarErrorCampo('message', 'El mensaje debe tener al menos 10 caracteres');
            esValido = false;
        }

        return esValido;
    }

    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    function limpiarErrores() {
        document.querySelectorAll('.form-error').forEach(el => el.textContent = '');
        errorMessage.style.display = 'none';
        successMessage.style.display = 'none';
    }

    function mostrarErrorCampo(campoId, mensaje) {
        document.getElementById(campoId + 'Error').textContent = mensaje;
    }

    function mostrarExito(mensaje) {
        successMessage.textContent = mensaje;
        successMessage.style.display = 'block';
        errorMessage.style.display = 'none';
        successMessage.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    function mostrarError(mensaje) {
        errorMessage.textContent = mensaje;
        errorMessage.style.display = 'block';
        successMessage.style.display = 'none';
        errorMessage.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
</script>
