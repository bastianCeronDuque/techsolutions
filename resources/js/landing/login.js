document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('form');
    const msg = document.getElementById('msg');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        msg.textContent = '⏳ Validando...';
        
        const data = Object.fromEntries(new FormData(form));
        try {
            const res = await fetch('/api/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            });
            
            const json = await res.json();
            
            if (res.ok) {
                msg.innerHTML = '✅ <strong>¡Bienvenido!</strong><br>Redirigiendo...';
                localStorage.setItem('token', json.token);
                setTimeout(() => window.location.href = '/dashboard', 1500);
            } else {
                msg.innerHTML = `❌ ${json.message || 'Error'}<br><small>${JSON.stringify(json.errors || {}, null, 2)}</small>`;
            }
        } catch (error) {
            msg.innerHTML = '⚠️ Error de conexión';
        }
    });

    // Botón para probar API
    const testBtn = document.createElement('button');
    testBtn.textContent = 'Probar mi sesión';
    testBtn.className = 'btn-secondary';
    testBtn.style.marginTop = '10px';
    form.parentNode.insertBefore(testBtn, msg.nextSibling);
    
    testBtn.addEventListener('click', async () => {
        const token = localStorage.getItem('token');
        if (!token) {
            msg.textContent = '🔐 Inicia sesión primero';
            return;
        }
        
        try {
            const res = await fetch('/api/me', {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            });
            
            const json = await res.json();
            msg.innerHTML = res.ok 
                ? `👤 <strong>Usuario autenticado:</strong><br><pre>${JSON.stringify(json.user, null, 2)}</pre>`
                : `❌ ${json.message || 'Error de autenticación'}`;
        } catch (error) {
            msg.textContent = '⚠️ Error al conectar con el servidor';
        }
    });

    // Efectos de partículas
    const colors = ['#4f46e5', '#16a34a', '#ec4899'];
    for (let i = 0; i < 15; i++) {
        const particle = document.createElement('div');
        particle.className = 'particle';
        Object.assign(particle.style, {
            width: `${Math.random() * 15 + 5}px`,
            height: `${Math.random() * 15 + 5}px`,
            left: `${Math.random() * 100}vw`,
            top: `${Math.random() * 100}vh`,
            animationDuration: `${Math.random() * 20 + 10}s`,
            opacity: Math.random() * 0.5 + 0.1,
            background: colors[Math.floor(Math.random() * colors.length)]
        });
        document.body.appendChild(particle);
    }
});