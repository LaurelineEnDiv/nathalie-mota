document.addEventListener('DOMContentLoaded', function () {
    const filterOptions = document.querySelectorAll('.filter-option');
    const loadMoreButton = document.querySelector('#load-more-photos');
    const sortOptions = document.querySelectorAll('[data-taxonomy="orderby"] .filter-option');
    let selectedFilters = {};

    // Gérer les clics sur les filtres
    filterOptions.forEach(option => {
        option.addEventListener('click', function () {
            const taxonomy = this.closest('.filter-group').getAttribute('data-taxonomy');
            const termId = this.getAttribute('data-term-id');

            // Ajouter ou retirer le filtre sélectionné
            if (selectedFilters[taxonomy] && selectedFilters[taxonomy].includes(termId)) {
                selectedFilters[taxonomy] = selectedFilters[taxonomy].filter(id => id !== termId);
            } else {
                selectedFilters[taxonomy] = selectedFilters[taxonomy] || [];
                selectedFilters[taxonomy].push(termId);
            }

            this.classList.toggle('active');
            fetchPhotos(1); // Charger les photos de la première page
        });
    });

    // Charger plus de photos
    loadMoreButton.addEventListener('click', function (e) {
        e.preventDefault();
        const nextPage = parseInt(this.getAttribute('data-paged')) + 1;
        fetchPhotos(nextPage);
    });

    // Fonction pour récupérer les photos via AJAX
    function fetchPhotos(page) {
        const formData = new FormData();
        formData.append('action', 'filter_photos');
        formData.append('filters', JSON.stringify(selectedFilters)); // Les filtres sélectionnés
        formData.append('paged', page); // La page actuelle
    
        document.getElementById('loading').style.display = 'block'; // Afficher le spinner de chargement
    
        fetch(myAjax.ajaxurl, {
            method: 'POST',
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (page === 1) {
                        photoContainer.innerHTML = data.data.html; // Remplace les photos
                    } else {
                        photoContainer.innerHTML += data.data.html; // Ajoute les nouvelles photos
                    }
                    loadMoreButton.setAttribute('data-paged', page);
                }
            })
            .finally(() => {
                document.getElementById('loading').style.display = 'none'; // Cacher le spinner
            });
    }

    // Trier par date
    sortOptions.forEach(option => {
        option.addEventListener('click', function () {
            const termId = this.getAttribute('data-term-id');
    
            // Mettre à jour le tri
            selectedFilters['orderby'] = [termId];
    
            // Marquer comme actif
            sortOptions.forEach(opt => opt.classList.remove('active'));
            this.classList.add('active');
    
            // Rafraîchir les photos
            fetchPhotos(1);
        });
    });
    
});
