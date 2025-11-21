@extends('layouts.app')

@section('title', 'Modifier Athlète')
@section('page-title', 'Modifier Athlète')
@section('page-description', $athlete->full_name)

@section('content')
<div class="max-w-5xl mx-auto">
    <button data-url="{{ route('athletes.show', $athlete) }}" class="js-redirect mb-6 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
        <i class="bi bi-arrow-left mr-2"></i>Retour au profil
    </button>

    <form action="{{ route('athletes.update', $athlete) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- 1. Informations Générales -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class="bi bi-person-circle mr-2 text-blue-600"></i>
                1. Informations Générales
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom *</label>
                    <input type="text" name="nom" required value="{{ old('nom', $athlete->nom) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Prénom *</label>
                    <input type="text" name="prenom" required value="{{ old('prenom', $athlete->prenom) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Genre *</label>
                    <select name="genre" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="Homme" {{ old('genre', $athlete->genre) == 'Homme' ? 'selected' : '' }}>Homme</option>
                        <option value="Femme" {{ old('genre', $athlete->genre) == 'Femme' ? 'selected' : '' }}>Femme</option>
                        <option value="Autre" {{ old('genre', $athlete->genre) == 'Autre' ? 'selected' : '' }}>Autre</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date de Naissance *</label>
                    <input type="date" name="date_naissance" required value="{{ old('date_naissance', $athlete->date_naissance->format('Y-m-d')) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                    <input type="email" name="email" required value="{{ old('email', $athlete->email) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone *</label>
                    <input type="tel" name="telephone" required value="{{ old('telephone', $athlete->telephone) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Adresse Postale *</label>
                    <textarea name="adresse_postale" required rows="2"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('adresse_postale', $athlete->adresse_postale) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ville *</label>
                    <input type="text" name="ville" required value="{{ old('ville', $athlete->ville) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">N° Certificat d'Handicap *</label>
                    <input type="text" name="numero_certificat_handicap" required value="{{ old('numero_certificat_handicap', $athlete->numero_certificat_handicap) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Taille (cm)</label>
                    <input type="number" name="taille" value="{{ old('taille', $athlete->taille) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Poids (kg)</label>
                    <input type="number" step="0.01" name="poids" value="{{ old('poids', $athlete->poids) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Lien</label>
                    <input type="url" name="lien" value="{{ old('lien', $athlete->lien) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pointure</label>
                    <input type="number" name="pointure" value="{{ old('pointure', $athlete->pointure) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Taille Vestimentaire</label>
                    <select name="taille_vestimentaire" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">Sélectionner</option>
                        @foreach(['XS', 'S', 'M', 'L', 'XL', 'XXL'] as $taille)
                        <option value="{{ $taille }}" {{ old('taille_vestimentaire', $athlete->taille_vestimentaire) == $taille ? 'selected' : '' }}>{{ $taille }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="chaise_roulante" value="1" {{ old('chaise_roulante', $athlete->chaise_roulante) ? 'checked' : '' }}
                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label class="ml-2 text-sm font-medium text-gray-700">Utilise une Chaise Roulante</label>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Allergie Alimentaire</label>
                    <textarea name="allergie_alimentaire" rows="2"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('allergie_alimentaire', $athlete->allergie_alimentaire) }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Maladie</label>
                    <textarea name="maladie" rows="2"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('maladie', $athlete->maladie) }}</textarea>
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
                                   {{ in_array($activite, old('activites_collectives', $athlete->activites_collectives ?? [])) ? 'checked' : '' }}
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
                                   {{ in_array($activite, old('activites_individuelles', $athlete->activites_individuelles ?? [])) ? 'checked' : '' }}
                                   class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="text-sm">{{ $activite }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Autres Activités</label>
                    <textarea name="autres_activites" rows="2"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('autres_activites', $athlete->autres_activites) }}</textarea>
                </div>
            </div>
        </div>

        <!-- 3. Personne à Contacter -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class="bi bi-telephone mr-2 text-blue-600"></i>
                3. Personne à Contacter
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom *</label>
                    <input type="text" name="contact_nom" required value="{{ old('contact_nom', $athlete->contact_nom) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Prénom *</label>
                    <input type="text" name="contact_prenom" required value="{{ old('contact_prenom', $athlete->contact_prenom) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                    <input type="email" name="contact_email" required value="{{ old('contact_email', $athlete->contact_email) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone *</label>
                    <input type="tel" name="contact_telephone" required value="{{ old('contact_telephone', $athlete->contact_telephone) }}"
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
                    @if($athlete->certificat_handicap_path)
                    <div class="mb-2 p-2 bg-green-50 rounded text-sm flex items-center justify-between">
                        <span class="text-green-700"><i class="bi bi-check-circle mr-1"></i>Document existant</span>
                        <a href="{{ asset('storage/' . $athlete->certificat_handicap_path) }}" target="_blank" class="text-blue-600 hover:underline">
                            <i class="bi bi-eye"></i> Voir
                        </a>
                    </div>
                    @endif
                    <input type="file" name="certificat_handicap" accept=".pdf,.jpg,.jpeg,.png"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Laisser vide pour conserver le document actuel</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">CIN ou Livret de Famille</label>
                    @if($athlete->cin_livret_path)
                    <div class="mb-2 p-2 bg-green-50 rounded text-sm flex items-center justify-between">
                        <span class="text-green-700"><i class="bi bi-check-circle mr-1"></i>Document existant</span>
                        <a href="{{ asset('storage/' . $athlete->cin_livret_path) }}" target="_blank" class="text-blue-600 hover:underline">
                            <i class="bi bi-eye"></i> Voir
                        </a>
                    </div>
                    @endif
                    <input type="file" name="cin_livret" accept=".pdf,.jpg,.jpeg,.png"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Laisser vide pour conserver le document actuel</p>
                </div>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex justify-end space-x-3">
            <button type="button" onclick="event.preventDefault();" data-url="{{ route('athletes.show', $athlete) }}" class="js-redirect px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                Annuler
            </button>
            <button type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <i class="bi bi-check-circle mr-2"></i>Enregistrer les Modifications
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
