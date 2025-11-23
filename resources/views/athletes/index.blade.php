@extends('layouts.app')

@section('title', 'Liste des Athlètes')
@section('page-title', 'Athlètes')
@section('page-description', 'Gérer les athlètes inscrits')

@section('content')
<div class="space-y-6">

    <!-- Actions Header -->
    <div class="flex justify-between items-center">

        <div class="flex space-x-2">
            <button data-url="{{ route('athletes.index') }}" class="js-redirect px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="bi bi-list-ul mr-2"></i>Liste des Athlètes
            </button>

            <button data-url="{{ route('athletes.create') }}" class="js-redirect px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                <i class="bi bi-plus-circle mr-2"></i>Nouveau Athlète
            </button>
        </div>

        <!-- SEARCH BAR (globale) -->
        <div class="flex items-center space-x-2">
            <input id="search" type="text" placeholder="Recherche rapide..." value="{{ request('search') }}"
                   class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <button id="clear-search" class="px-3 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">Effacer</button>
        </div>

    </div>

    <!-- Filters -->
    <div class="bg-white p-4 rounded-lg shadow flex flex-wrap gap-4 items-end">
        <div>
            <label class="block text-xs text-gray-600">Nom</label>
            <input id="filter-nom" name="nom" type="text" value="{{ request('nom') }}" class="px-3 py-2 border rounded">
        </div>

        <div>
            <label class="block text-xs text-gray-600">Prénom</label>
            <input id="filter-prenom" name="prenom" type="text" value="{{ request('prenom') }}" class="px-3 py-2 border rounded">
        </div>

        <div>
            <label class="block text-xs text-gray-600">Sexe</label>
            <select id="filter-genre" name="genre" class="px-3 py-2 border rounded">
                <option value="">Tous</option>
                @foreach($genres as $g)
                    <option value="{{ $g }}" @if(request('genre') == $g) selected @endif>{{ $g }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-xs text-gray-600">Ville</label>
            <select id="filter-ville" name="ville" class="px-3 py-2 border rounded">
                <option value="">Toutes</option>
                @foreach($villes as $v)
                    <option value="{{ $v }}" @if(request('ville') == $v) selected @endif>{{ $v }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-xs text-gray-600">Activités collectives</label>
            <input id="filter-act-col" name="activites_collectives" type="text" value="{{ request('activites_collectives') }}" class="px-3 py-2 border rounded">
        </div>

        <div>
            <label class="block text-xs text-gray-600">Activités individuelles</label>
            <input id="filter-act-ind" name="activites_individuelles" type="text" value="{{ request('activites_individuelles') }}" class="px-3 py-2 border rounded">
        </div>

        <div>
            <label class="block text-xs text-gray-600">Autres activités</label>
            <input id="filter-autres" name="autres_activites" type="text" value="{{ request('autres_activites') }}" class="px-3 py-2 border rounded">
        </div>

        <div class="ml-auto">
            <button id="reset-filters" class="px-4 py-2 bg-gray-200 rounded">Réinitialiser</button>
        </div>
    </div>

    <!-- Table container (remplacée par AJAX) -->
    <div id="athletes-table" class="mt-4">
        @include('athletes._table')
    </div>

</div>

<!-- JS AJAX: recherche + filtres + pagination dynamique -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    // éléments
    const inputs = {
        search: document.getElementById('search'),
        nom: document.getElementById('filter-nom'),
        prenom: document.getElementById('filter-prenom'),
        genre: document.getElementById('filter-genre'),
        ville: document.getElementById('filter-ville'),
        act_col: document.getElementById('filter-act-col'),
        act_ind: document.getElementById('filter-act-ind'),
        autres: document.getElementById('filter-autres'),
    };
    const clearSearchBtn = document.getElementById('clear-search');
    const resetFiltersBtn = document.getElementById('reset-filters');
    const tableContainer = document.getElementById('athletes-table');

    // debounce util
    function debounce(fn, wait) {
        let t;
        return function(...args) {
            clearTimeout(t);
            t = setTimeout(() => fn.apply(this, args), wait);
        };
    }

    // construit les params de la query selon les inputs non vides
    function buildParams(override = {}) {
        const params = new URLSearchParams();

        if (inputs.search.value.trim() !== '') params.set('search', inputs.search.value.trim());
        if (inputs.nom.value.trim() !== '') params.set('nom', inputs.nom.value.trim());
        if (inputs.prenom.value.trim() !== '') params.set('prenom', inputs.prenom.value.trim());
        if (inputs.genre.value !== '') params.set('genre', inputs.genre.value);
        if (inputs.ville.value !== '') params.set('ville', inputs.ville.value);
        if (inputs.act_col.value.trim() !== '') params.set('activites_collectives', inputs.act_col.value.trim());
        if (inputs.act_ind.value.trim() !== '') params.set('activites_individuelles', inputs.act_ind.value.trim());
        if (inputs.autres.value.trim() !== '') params.set('autres_activites', inputs.autres.value.trim());

        // override (ex: page param)
        Object.keys(override).forEach(k => {
            if (override[k] === null) params.delete(k);
            else params.set(k, override[k]);
        });

        return params.toString();
    }

    // effectue la requête AJAX et remplace la table
    async function fetchTable(queryString, pushState = true) {
        const url = '{{ route("athletes.search") }}' + (queryString ? ('?' + queryString) : '');
        try {
            const res = await fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            if (!res.ok) throw new Error('Network response was not ok');
            const data = await res.json();
            tableContainer.innerHTML = data.html;

            // réinitialise les handlers pour redirections et pagination (contenu remplacé)
            bindRowClicks();
            bindPaginationLinks();

            // met à jour l'URL (historique)
            if (pushState) {
                const newUrl = '{{ route("athletes.index") }}' + (queryString ? ('?' + queryString) : '');
                history.pushState({}, '', newUrl);
            }
        } catch (err) {
            console.error(err);
        }
    }

    // gère le clic sur les lignes et boutons js-redirect
    function bindRowClicks() {
        document.querySelectorAll('.js-redirect').forEach(function(el){
            el.addEventListener('click', function(e){
                if(e) e.preventDefault();
                var url = this.getAttribute('data-url');
                if(url) window.location.href = url;
            });
        });

        document.querySelectorAll('.clickable-row').forEach(function(row){
            row.addEventListener('click', function(e){
                var url = this.getAttribute('data-url');
                if(url) window.location.href = url;
            });
        });
    }

    // intercepte les liens de pagination et charge en AJAX
    function bindPaginationLinks() {
        document.querySelectorAll('#athletes-table .pagination a').forEach(function(link){
            link.addEventListener('click', function(e){
                e.preventDefault();
                const href = this.getAttribute('href');
                // extrait page param
                const url = new URL(href, window.location.origin);
                const page = url.searchParams.get('page');
                const params = buildParams({ page: page });
                fetchTable(params, true);
            });
        });
    }

    // écoute les changements (avec debounce)
    const debouncedFetch = debounce(function(){
        // quand on change filtres, on revient à la page 1
        const params = buildParams({ page: 1 });
        fetchTable(params, true);
    }, 350);

    Object.values(inputs).forEach(i => {
        i.addEventListener('input', debouncedFetch);
        i.addEventListener('change', debouncedFetch);
    });

    // clear search
    clearSearchBtn.addEventListener('click', function(){
        inputs.search.value = '';
        debouncedFetch();
    });

    // reset filters
    resetFiltersBtn.addEventListener('click', function(e){
        e.preventDefault();
        Object.values(inputs).forEach(inp => {
            if(inp.tagName.toLowerCase() === 'select') inp.selectedIndex = 0;
            else inp.value = '';
        });
        // fetch all (page 1)
        const params = buildParams({ page: 1 });
        fetchTable(params, true);
    });

    // handle browser back/forward (restaurer l'état via query string)
    window.addEventListener('popstate', function (event) {
        // parse current URL params and populate inputs, puis fetch
        const urlParams = new URLSearchParams(window.location.search);
        inputs.search.value = urlParams.get('search') || '';
        inputs.nom.value = urlParams.get('nom') || '';
        inputs.prenom.value = urlParams.get('prenom') || '';
        inputs.genre.value = urlParams.get('genre') || '';
        inputs.ville.value = urlParams.get('ville') || '';
        inputs.act_col.value = urlParams.get('activites_collectives') || '';
        inputs.act_ind.value = urlParams.get('activites_individuelles') || '';
        inputs.autres.value = urlParams.get('autres_activites') || '';

        const params = buildParams();
        fetchTable(params, false);
    });

    // initial bindings
    bindRowClicks();
    bindPaginationLinks();
});
</script>
@endsection
