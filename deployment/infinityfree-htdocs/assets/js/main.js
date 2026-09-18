/**
 * JavaScript Global — ONG Espoir d'Avenir
 */

document.addEventListener('DOMContentLoaded', () => {
    const currentDate = document.getElementById('current-date');
    const currentTime = document.getElementById('current-time');

    if (currentDate && currentTime) {
        const updateDateTime = () => {
            const now = new Date();
            currentDate.textContent = new Intl.DateTimeFormat('fr-FR', {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            }).format(now);
            currentTime.textContent = new Intl.DateTimeFormat('fr-FR', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            }).format(now);
        };

        updateDateTime();
        setInterval(updateDateTime, 1000);
    }

    // Disparition automatique des alertes flash après 6 secondes
    const flashAlerts = document.querySelectorAll('.flash-container .alert');
    if (flashAlerts.length > 0) {
        setTimeout(() => {
            flashAlerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 6000);
    }

    // Navigation de la galerie des actions terminées
    const gallerySections = document.querySelectorAll('.terminated-gallery-section');

    gallerySections.forEach(section => {
        const wrapper = section.querySelector('.terminated-gallery-wrapper');
        const prevBtn = section.querySelector('.terminated-gallery-prev');
        const nextBtn = section.querySelector('.terminated-gallery-next');

        if (!wrapper || !prevBtn || !nextBtn) {
            return;
        }

        const scrollGallery = (direction) => {
            const amount = Math.max(wrapper.clientWidth * 0.85, 260);
            wrapper.scrollBy({
                left: direction * amount,
                behavior: 'smooth'
            });
        };

        prevBtn.addEventListener('click', () => scrollGallery(-1));
        nextBtn.addEventListener('click', () => scrollGallery(1));
    });
});
