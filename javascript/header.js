// Script pour gérer l'ouverture/fermeture du menu sidebar
document.addEventListener('DOMContentLoaded', function() {
    const sidebarToggle = document.querySelector('.sidebar-toggle');
    const sidebar = document.querySelector('.sidebar');
    const body = document.body;
    
    // Initialiser le sidebar comme collapsed sur mobile au chargement
    function initializeSidebar() {
        if (window.innerWidth <= 768) {
            sidebar.classList.add('collapsed');
        } else {
            // Sur desktop, le sidebar peut être ouvert par défaut
            sidebar.classList.remove('collapsed');
        }
    }
    
    // Fonction pour basculer l'état du sidebar
    function toggleSidebar() {
        sidebar.classList.toggle('collapsed');
    }
    
    // Écouteur d'événement pour le bouton de toggle
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            toggleSidebar();
        });
    }
    
    // Fermer le sidebar quand on clique sur l'overlay (mobile uniquement)
    document.addEventListener('click', function(e) {
        // Vérifier si on est sur mobile et si le sidebar est ouvert
        if (window.innerWidth <= 768 && !sidebar.classList.contains('collapsed')) {
            const isClickInsideSidebar = sidebar.contains(e.target);
            const isClickOnToggle = e.target.closest('.sidebar-toggle');
            
            // Si on clique en dehors du sidebar et ce n'est pas le bouton toggle
            if (!isClickInsideSidebar && !isClickOnToggle) {
                sidebar.classList.add('collapsed');
            }
        }
    });
    
    // Gérer le redimensionnement de la fenêtre
    window.addEventListener('resize', function() {
        initializeSidebar();
    });
    
    // Initialiser au chargement
    initializeSidebar();
    
    // Gestion du toggle de thème (si vous voulez l'ajouter)
    const themeToggle = document.querySelector('.theme-toggle');
    if (themeToggle) {
        themeToggle.addEventListener('click', function() {
            body.classList.toggle('dark-theme');
            
            // Sauvegarder la préférence de thème
            const isDark = body.classList.contains('dark-theme');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
        });
        
        // Charger la préférence de thème sauvegardée
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'dark') {
            body.classList.add('dark-theme');
        }
    }
});