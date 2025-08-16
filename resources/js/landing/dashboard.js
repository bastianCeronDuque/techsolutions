document.addEventListener('DOMContentLoaded', () => {
    // Toggle mobile menu (si es necesario)
    const mobileMenuButton = document.createElement('button');
    mobileMenuButton.innerHTML = '☰';
    mobileMenuButton.className = 'mobile-menu-btn';
    
    // Solo añadir en mobile
    if (window.innerWidth < 768) {
        document.querySelector('.topbar').prepend(mobileMenuButton);
        
        mobileMenuButton.addEventListener('click', () => {
            document.querySelector('.sidebar').classList.toggle('active');
        });
    }

    // Mostrar notificación de bienvenida
    if (!localStorage.getItem('welcomeShown')) {
        setTimeout(() => {
            showNotification('Bienvenido al dashboard');
            localStorage.setItem('welcomeShown', 'true');
        }, 1000);
    }

    // Cerrar sesión con confirmación
    const logoutForm = document.querySelector('.logout form');
    if (logoutForm) {
        logoutForm.addEventListener('submit', (e) => {
            if (!confirm('¿Estás seguro de cerrar sesión?')) {
                e.preventDefault();
            }
        });
    }
});

function showNotification(message) {
    const notification = document.createElement('div');
    notification.className = 'notification';
    notification.textContent = message;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.add('show');
    }, 100);
    
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => notification.remove(), 500);
    }, 3000);
}