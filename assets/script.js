// Fonction pour envoyer la requête de filtrage au serveur
function filterVehicles() {
    const minPrice = document.getElementById('minPrice').value;
    const maxPrice = document.getElementById('maxPrice').value;
    const maxMileage = document.getElementById('maxMileage').value;
    const year = document.getElementById('year').value;

    // Envoyer une requête AJAX au serveur
    $.ajax({
        url: 'filter_vehicles.php',
        type: 'POST',
        data: {
            minPrice: minPrice,
            maxPrice: maxPrice,
            maxMileage: maxMileage,
            year: year
        },
        success: function(response) {
            // Afficher les résultats filtrés
            document.getElementById('results').innerHTML = response;
        },
        error: function(xhr, status, error) {
            console.log(error);
        }
    });
}

// Ajoutez un gestionnaire d'événements pour le bouton de filtrage
document.getElementById('filterBtn').addEventListener('click', filterVehicles);
