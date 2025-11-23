/**
 * Gestion des athlètes - JavaScript
 * Version : 1.0
 */

// ===============================================
// 1. GESTION DES REDIRECTIONS
// ===============================================
document.addEventListener('DOMContentLoaded', function() {
    // Boutons avec data-url
    document.querySelectorAll('.js-redirect').forEach(function(el) {
        el.addEventListener('click', function(e) {
            e.preventDefault();
            const url = this.getAttribute('data-url');
            if (url) window.location.href = url;
        });
    });

    // Lignes cliquables
    document.querySelectorAll('.clickable-row').forEach(function(row) {
        row.addEventListener('click', function() {
            const url = this.getAttribute('data-url');
            if (url) window.location.href = url;
        });
    });
});

// ===============================================
// 2. RECHERCHE EN TEMPS RÉEL
// ===============================================
let searchTimeout = null;
const searchInput = document.getElementById('searchInput');
const athletesContainer = document.getElementById('athletesTable');
const loadingIndicator = document.getElementById('loadingIndicator');
const emptyState = document.getElementById('emptyState');

if (searchInput) {
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        
        searchTimeout = setTimeout(() => {
            performSearch(this.value);
        }, 500); // Attendre 500ms après la dernière frappe
    });
}

/**
 * Effectuer la recherche via API
 */
async function performSearch(query) {
    showLoading(true);
    
    try {
        const params = new URLSearchParams({
            search: query,
            page: 1
        });
        
        const response = await fetch(`/api/v1/athletes?${params}`);
        const data = await response.json();
        
        displayAthletes(data.data);
        updatePagination(data);
        
    } catch (error) {
        console.error('Erreur de recherche:', error);
        showNotification('Erreur lors de la recherche', 'error');
    } finally {
        showLoading(false);
    }
}

/**
 * Afficher les athlètes dans le tableau
 */
function displayAthletes(athletes) {
    const tbody = document.querySelector('#athletesTable tbody');
    
    if (athletes.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                    <i class="bi bi-inbox text-4xl block mb-2"></i>
                    <p>Aucun athlète trouvé</p>
                </td>
            </tr>
        `;
        return;
    }
    
    tbody.innerHTML = athletes.map(athlete => `
        <tr class="hover:bg-gray-50 transition cursor-pointer clickable-row" data-url="/athletes/${athlete.id}">
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10">
                        <img class="h-10 w-10 rounded-full" 
                             src="https://ui-avatars.com/api/?name=${encodeURIComponent(athlete.full_name)}&background=random" 
                             alt="${athlete.full_name}">
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-900">${athlete.full_name}</div>
                        <div class="text-sm text-gray-500">${athlete.genre} • ${athlete.age} ans</div>
                    </div>
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900">${athlete.email}</div>
                <div class="text-sm text-gray-500">${athlete.telephone}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${athlete.ville}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${athlete.numero_certificat_handicap}</td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                    Actif
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <button onclick="event.stopPropagation(); window.location.href='/athletes/${athlete.id}/edit'" 
                        class="text-blue-600 hover:text-blue-900 mr-3">
                    <i class="bi bi-pencil"></i>
                </button>
                <button onclick="event.stopPropagation(); confirmDelete(${athlete.id}, '${athlete.full_name}')" 
                        class="text-red-600 hover:text-red-900">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        </tr>
    `).join('');
    
    // Réattacher les événements
    attachRowClickEvents();
}

/**
 * Réattacher les événements de clic sur les lignes
 */
function attachRowClickEvents() {
    document.querySelectorAll('.clickable-row').forEach(function(row) {
        row.addEventListener('click', function() {
            const url = this.getAttribute('data-url');
            if (url) window.location.href = url;
        });
    });
}

/**
 * Mettre à jour la pagination
 */
function updatePagination(data) {
    const paginationContainer = document.getElementById('pagination');
    
    if (!paginationContainer || data.last_page <= 1) {
        if (paginationContainer) paginationContainer.innerHTML = '';
        return;
    }
    
    let paginationHTML = '<div class="flex justify-center items-center space-x-2 mt-6">';
    
    // Bouton Précédent
    if (data.current_page > 1) {
        paginationHTML += `
            <button onclick="loadPage(${data.current_page - 1})" 
                    class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                <i class="bi bi-chevron-left"></i>
            </button>
        `;
    }
    
    // Pages
    for (let i = Math.max(1, data.current_page - 2); i <= Math.min(data.last_page, data.current_page + 2); i++) {
        const active = i === data.current_page ? 'bg-blue-600 text-white' : 'bg-white hover:bg-gray-50';
        paginationHTML += `
            <button onclick="loadPage(${i})" 
                    class="px-4 py-2 border border-gray-300 rounded-lg ${active}">
                ${i}
            </button>
        `;
    }
    
    // Bouton Suivant
    if (data.current_page < data.last_page) {
        paginationHTML += `
            <button onclick="loadPage(${data.current_page + 1})" 
                    class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                <i class="bi bi-chevron-right"></i>
            </button>
        `;
    }
    
    paginationHTML += '</div>';
    paginationContainer.innerHTML = paginationHTML;
}

/**
 * Charger une page spécifique
 */
async function loadPage(page) {
    showLoading(true);
    
    try {
        const search = searchInput ? searchInput.value : '';
        const params = new URLSearchParams({
            search: search,
            page: page
        });
        
        const response = await fetch(`/api/v1/athletes?${params}`);
        const data = await response.json();
        
        displayAthletes(data.data);
        updatePagination(data);
        
        window.scrollTo({ top: 0, behavior: 'smooth' });
        
    } catch (error) {
        console.error('Erreur:', error);
    } finally {
        showLoading(false);
    }
}

/**
 * Afficher/masquer l'indicateur de chargement
 */
function showLoading(show) {
    if (loadingIndicator) {
        loadingIndicator.style.display = show ? 'block' : 'none';
    }
    
    const tbody = document.querySelector('#athletesTable tbody');
    if (show && tbody) {
        tbody.style.opacity = '0.5';
    } else if (tbody) {
        tbody.style.opacity = '1';
    }
}

// ===============================================
// 3. SUPPRESSION AVEC CONFIRMATION
// ===============================================
let athleteToDelete = null;

function confirmDelete(id, name) {
    athleteToDelete = id;
    
    const modal = document.getElementById('deleteModal');
    const athleteName = document.getElementById('athleteName');
    
    if (athleteName) {
        athleteName.textContent = name;
    }
    
    if (modal) {
        modal.classList.remove('hidden');
    }
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    if (modal) {
        modal.classList.add('hidden');
    }
    athleteToDelete = null;
}

async function deleteAthlete() {
    if (!athleteToDelete) return;
    
    try {
        const response = await fetch(`/api/v1/athletes/${athleteToDelete}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });
        
        if (response.ok) {
            showNotification('Athlète supprimé avec succès', 'success');
            closeDeleteModal();
            
            // Recharger la page actuelle
            const search = searchInput ? searchInput.value : '';
            performSearch(search);
        } else {
            showNotification('Erreur lors de la suppression', 'error');
        }
    } catch (error) {
        console.error('Erreur:', error);
        showNotification('Erreur lors de la suppression', 'error');
    }
}

// ===============================================
// 4. NOTIFICATIONS
// ===============================================
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg text-white z-50 ${
        type === 'success' ? 'bg-green-500' : 
        type === 'error' ? 'bg-red-500' : 
        'bg-blue-500'
    }`;
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="bi ${
                type === 'success' ? 'bi-check-circle-fill' : 
                type === 'error' ? 'bi-x-circle-fill' : 
                'bi-info-circle-fill'
            } mr-2"></i>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transition = 'opacity 0.3s';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// ===============================================
// 5. INITIALISATION
// ===============================================
console.log('✅ Athletes.js chargé avec succès');