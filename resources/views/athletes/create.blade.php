@extends('layouts.app')

@section('title', 'Nouveau Athlète')
@section('page-title', 'Inscription Athlète')
@section('page-description', 'Enregistrer un nouvel athlète')

@section('content')
<div class="max-w-5xl mx-auto">
    @isset($athletes)
    @php
        $__athletes_dump = (is_object($athletes) && method_exists($athletes, 'toArray')) ? print_r($athletes->toArray(), true) : print_r($athletes, true);
    @endphp
    <div class="mb-4 p-4 bg-yellow-50 border border-yellow-200 rounded">
        <h4 class="font-semibold text-sm mb-2">Variable <code>$athletes</code> (debug)</h4>
        <pre class="text-xs overflow-auto whitespace-pre-wrap">{{ $__athletes_dump }}</pre>
    </div>
    @endisset
    <div class="flex space-x-2 mb-6">
        <button data-url="{{ route('athletes.index') }}" class="js-redirect px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
            <i class="bi bi-arrow-left mr-2"></i>Retour à la liste
        </button>
    </div>

<form action="{{ route('athletes.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf

    <!-- 1. Informations Générales -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <i class="bi bi-person-circle mr-2 text-blue-600"></i>
            1. Informations Générales
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nom *</label>
                <input type="text" name="nom" required value="{{ old('nom') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Prénom *</label>
                <input type="text" name="prenom" required value="{{ old('prenom') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Genre *</label>
                <select name="genre" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Sélectionner</option>
                    <option value="Homme" {{ old('genre') == 'Homme' ? 'selected' : '' }}>Homme</option>
                    <option value="Femme" {{ old('genre') == 'Femme' ? 'selected' : '' }}>Femme</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date de Naissance *</label>
                <input type="date" name="date_naissance" required value="{{ old('date_naissance') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                <input type="email" name="email" required value="{{ old('email') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone *</label>
                <input type="tel" name="telephone" required value="{{ old('telephone') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Adresse Postale *</label>
                <textarea name="adresse_postale" required rows="2"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('adresse_postale') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Ville *</label>
                <input type="text" name="ville" required value="{{ old('ville') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">N° Certificat d'Handicap *</label>
                <input type="text" name="numero_certificat_handicap" required value="{{ old('numero_certificat_handicap') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Taille (cm)</label>
                <input type="number" name="taille" value="{{ old('taille') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Poids (kg)</label>
                <input type="number" step="0.01" name="poids" value="{{ old('poids') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Lien</label>
                <input type="url" name="lien" value="{{ old('lien') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pointure</label>
                <input type="number" name="pointure" value="{{ old('pointure') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Taille Vestimentaire</label>
                <select name="taille_vestimentaire" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Sélectionner</option>
                    <option value="XS">XS</option>
                    <option value="S">S</option>
                    <option value="M">M</option>
                    <option value="L">L</option>
                    <option value="XL">XL</option>
                    <option value="XXL">XXL</option>
                </select>
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="chaise_roulante" value="1" {{ old('chaise_roulante') ? 'checked' : '' }}
                       class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <label class="ml-2 text-sm font-medium text-gray-700">Utilise une Chaise Roulante</label>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Allergie Alimentaire</label>
                <textarea name="allergie_alimentaire" rows="2"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('allergie_alimentaire') }}</textarea>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Maladie</label>
                <textarea name="maladie" rows="2"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('maladie') }}</textarea>
            </div>
        </div>
    </div>

    <!-- 2. Activités Pratiquées -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <i class="bi bi-activity mr-2 text-blue-600"></i>
            2. Activités Pratiquées
        </h3>
        
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Activités Collectives</label>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                    @foreach(['Football', 'Basketball', 'Volleyball', 'Handball', 'Rugby'] as $activite)
                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded hover:bg-gray-50 cursor-pointer">
                        <input type="checkbox" name="activites_collectives[]" value="{{ $activite }}" 
                               class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <span class="text-sm">{{ $activite }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Activités Individuelles</label>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                    @foreach(['Athlétisme', 'Natation', 'Tennis', 'Cyclisme', 'Judo', 'Escrime'] as $activite)
                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded hover:bg-gray-50 cursor-pointer">
                        <input type="checkbox" name="activites_individuelles[]" value="{{ $activite }}" 
                               class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <span class="text-sm">{{ $activite }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Autres Activités</label>
                <textarea name="autres_activites" rows="2"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('autres_activites') }}</textarea>
            </div>
        </div>
    </div>

    <!-- 3. Personne à Contacter -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <i class="bi bi-telephone mr-2 text-blue-600"></i>
            3. Personne à Contacter (en cas d'urgence)
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nom *</label>
                <input type="text" name="contact_nom" required value="{{ old('contact_nom') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Prénom *</label>
                <input type="text" name="contact_prenom" required value="{{ old('contact_prenom') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                <input type="email" name="contact_email" required value="{{ old('contact_email') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone *</label>
                <input type="tel" name="contact_telephone" required value="{{ old('contact_telephone') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
        </div>
    </div>

    <!-- 4. Documents Requis -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <i class="bi bi-file-earmark-text mr-2 text-blue-600"></i>
            4. Documents Requis
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Certificat d'Handicap</label>
                <input type="file" name="certificat_handicap" accept=".pdf,.jpg,.jpeg,.png"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                <p class="text-xs text-gray-500 mt-1">PDF, JPG, PNG (Max 2MB)</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">CIN ou Livret de Famille</label>
                <input type="file" name="cin_livret" accept=".pdf,.jpg,.jpeg,.png"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                <p class="text-xs text-gray-500 mt-1">PDF, JPG, PNG (Max 2MB)</p>
            </div>
        </div>
    </div>

    <!-- Submit Buttons -->
    <div class="flex justify-end space-x-3">
        <button type="button" onclick="event.preventDefault();" data-url="{{ route('athletes.index') }}" class="js-redirect px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
            Annuler
        </button>
        <button type="submit" 
                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            <i class="bi bi-check-circle mr-2"></i>Enregistrer l'Athlète
        </button>
    </div>
</form>
</div>
<script>
document.addEventListener('DOMContentLoaded', function(){
    document.querySelectorAll('.js-redirect').forEach(function(el){
        el.addEventListener('click', function(e){
            if(e) e.preventDefault();
            var url = this.getAttribute('data-url');
            if(url) window.location.href = url;
        });
    });
});
</script>
@endsection