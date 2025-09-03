    const burger = document.getElementById('burger-menu');
const navLinks = document.getElementById('nav-links');
burger.addEventListener('click', () => {
    navLinks.classList.toggle('nav-active');
    burger.classList.toggle('toggle');
});

// Fonction pour ouvrir la popup de téléchargement
function openModal(documentName = '') {
    const modal = document.getElementById('popup');
    const documentNameElement = document.getElementById('document-name');
    
    if (documentNameElement) {
        documentNameElement.textContent = documentName;
    }
    
    if (modal) {
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden'; // Empêche le défilement de la page
        document.documentElement.style.paddingRight = window.innerWidth - document.documentElement.clientWidth + 'px';
    }
}

// Fonction pour fermer la popup
function closeModal() {
    const modal = document.getElementById('popup');
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto'; // Réactive le défilement de la page
        document.documentElement.style.paddingRight = '0';
    }
}

// Fermer la popup avec la touche Échap
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeModal();
    }
});

// Fermer la popup en cliquant en dehors
window.onclick = function(event) {
    const modal = document.getElementById('popup');
    if (event.target === modal) {
        closeModal();
    }
};

// Gestion du formulaire de demande de documents
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('documentRequestForm');
    const documentTypeSelect = document.getElementById('documentType');
    const otherDocumentGroup = document.getElementById('otherDocumentGroup');
    const otherDocumentInput = document.getElementById('otherDocument');

    // Afficher/masquer le champ "Autre document" selon la sélection
    if (documentTypeSelect) {
        documentTypeSelect.addEventListener('change', function() {
            if (this.value === 'autre') {
                otherDocumentGroup.style.display = 'block';
                otherDocumentInput.setAttribute('required', 'required');
            } else {
                otherDocumentGroup.style.display = 'none';
                otherDocumentInput.removeAttribute('required');
                otherDocumentInput.value = '';
            }
        });
    }

    // Gestion de la soumission du formulaire
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Animation de chargement
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Envoi en cours...';
            
            // Simulation d'envoi (à remplacer par un vrai appel AJAX)
            setTimeout(function() {
                // Réinitialiser le bouton
                submitBtn.innerHTML = '<i class="fas fa-check"></i> Envoyé !';
                submitBtn.style.backgroundColor = '#4CAF50';
                
                // Réinitialiser le formulaire après un délai
                setTimeout(function() {
                    form.reset();
                    submitBtn.innerHTML = originalBtnText;
                    submitBtn.disabled = false;
                    submitBtn.style.backgroundColor = '';
                    
                    // Afficher un message de succès
                    alert('Votre demande a bien été envoyée. Nous vous contacterons bientôt !');
                }, 1500);
            }, 1500);
        });
    }

    // Animation au défilement pour les cartes de documents
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries, observer) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Appliquer l'animation aux cartes de documents
    document.querySelectorAll('.document-card').forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = `opacity 0.5s ease ${index * 0.1}s, transform 0.5s ease ${index * 0.1}s`;
        observer.observe(card);
    });
});