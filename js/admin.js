// ============================================
// SCRIPT ADMIN - Navigation & UI communes
// Gestion du menu responsive et interactions
// ============================================

document.addEventListener('DOMContentLoaded', () => {
    // Éléments DOM
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const menuToggle = document.getElementById('menuToggle');
    const sidebarClose = document.getElementById('sidebarClose');
    
    // Fonction pour ouvrir le menu mobile
    function openMobileMenu() {
        if (sidebar && window.innerWidth <= 768) {
            sidebar.classList.add('open');
            if (overlay) overlay.style.display = 'block';
            document.body.style.overflow = 'hidden';
        }
    }
    
    // Fonction pour fermer le menu mobile
    function closeMobileMenu() {
        if (sidebar) {
            sidebar.classList.remove('open');
            if (overlay) overlay.style.display = 'none';
            document.body.style.overflow = '';
        }
    }
    
    // Event listeners pour le menu mobile
    if (menuToggle) {
        menuToggle.addEventListener('click', openMobileMenu);
    }
    
    if (sidebarClose) {
        sidebarClose.addEventListener('click', closeMobileMenu);
    }
    
    if (overlay) {
        overlay.addEventListener('click', closeMobileMenu);
    }
    
    // Fermer le menu lors du redimensionnement au-delà de 768px
    window.addEventListener('resize', () => {
        if (window.innerWidth > 768 && sidebar && sidebar.classList.contains('open')) {
            closeMobileMenu();
        }
    });
    
    // Animation des cartes au scroll (effet fade-in)
    const cards = document.querySelectorAll('.stat-card, .card');
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '0';
                entry.target.style.transform = 'translateY(20px)';
                entry.target.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                
                setTimeout(() => {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }, 100);
                
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    cards.forEach(card => observer.observe(card));
    
    // Tooltip personnalisé simple pour les boutons d'action
    const actionButtons = document.querySelectorAll('.btn-icon');
    actionButtons.forEach(btn => {
        btn.addEventListener('mouseenter', (e) => {
            const tooltip = document.createElement('div');
            tooltip.className = 'custom-tooltip';
            const action = btn.classList.contains('edit-skill') || btn.classList.contains('edit-city') ? 'Modifier' : 'Supprimer';
            tooltip.textContent = action;
            tooltip.style.position = 'absolute';
            tooltip.style.background = 'var(--gray-800)';
            tooltip.style.color = 'white';
            tooltip.style.padding = '4px 8px';
            tooltip.style.borderRadius = '4px';
            tooltip.style.fontSize = '12px';
            tooltip.style.pointerEvents = 'none';
            tooltip.style.zIndex = '1000';
            
            const rect = btn.getBoundingClientRect();
            tooltip.style.top = `${rect.top - 30 + window.scrollY}px`;
            tooltip.style.left = `${rect.left + rect.width / 2 - 20 + window.scrollX}px`;
            
            document.body.appendChild(tooltip);
            
            btn.addEventListener('mouseleave', () => {
                tooltip.remove();
            }, { once: true });
        });
    });
});