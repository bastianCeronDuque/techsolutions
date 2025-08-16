document.addEventListener('DOMContentLoaded', function() {
    // 1. Obtener elementos de manera segura
    const form = document.getElementById('registerForm');
    const msg = document.getElementById('registerMsg');
    const submitBtn = document.getElementById('registerBtn');
    
    // 2. Verificar que todos los elementos existen
    if (!form || !msg || !submitBtn) {
        console.error('Error: Elementos del formulario no encontrados');
        return;
    }
    
    // 3. Manejador de envío mejorado
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // Estado de carga
        toggleLoading(true, submitBtn);
        showMessage('⏳ Creando tu cuenta...', 'loading', msg);
        
        try {
            // Validación de contraseñas
            const password = form.querySelector('[name="password"]').value;
            const passwordConfirm = form.querySelector('[name="password_confirmation"]').value;
            
            if (password !== passwordConfirm) {
                throw {
                    errors: {
                        password_confirmation: ['Las contraseñas no coinciden']
                    }
                };
            }
            
            // Envío del formulario
            const response = await fetch('/api/register', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: new FormData(form)
            });
            
            const data = await response.json();
            
            if (!response.ok) {
                throw data;
            }
            
            // Éxito
            showMessage('✅ ¡Cuenta creada! Redirigiendo...', 'success', msg);
            form.reset();
            
            setTimeout(() => {
                window.location.href = '/login';
            }, 2000);
            
        } catch (error) {
            console.error('Error en registro:', error);
            handleFormError(error, form, msg);
        } finally {
            toggleLoading(false, submitBtn);
        }
    });
});

// Funciones auxiliares
function toggleLoading(isLoading, button) {
    const btnText = button.querySelector('.btn-text');
    const btnLoading = button.querySelector('.btn-loading');
    
    button.disabled = isLoading;
    btnText.classList.toggle('hidden', isLoading);
    btnLoading.classList.toggle('hidden', !isLoading);
}

function showMessage(text, type, container) {
    container.innerHTML = `<div class="${type}-msg">${text}</div>`;
}

function handleFormError(error, form, msgContainer) {
    let errorMessage = '❌ Error en el registro:<ul>';
    
    if (error.errors) {
        Object.entries(error.errors).forEach(([field, errors]) => {
            errors.forEach(err => errorMessage += `<li>${err}</li>`);
            
            // Resaltar campo con error
            const input = form.querySelector(`[name="${field}"]`);
            if (input) {
                input.classList.add('input-error');
                input.addEventListener('input', () => 
                    input.classList.remove('input-error')
                );
            }
        });
    } else {
        errorMessage += `<li>${error.message || 'Error desconocido'}</li>`;
    }
    
    errorMessage += '</ul>';
    showMessage(errorMessage, 'error', msgContainer);
}