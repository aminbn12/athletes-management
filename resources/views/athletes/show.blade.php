@extends('layouts.app')

@section('title', 'Profil Athlète')
@section('page-title', 'Profil Athlète')
@section('page-description', $athlete->full_name)

@section('content')
<div class="max-w-6xl mx-auto">
    <button data-url="{{ route('athletes.index') }}" class="js-redirect mb-6 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
        <i class="bi bi-arrow-left mr-2"></i>Retour à la liste
    </button>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Card -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="text-center">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($athlete->full_name) }}&size=200&background=3b82f6&color=fff" 
                         alt="{{ $athlete->full_name }}" 
                         class="w-32 h-32 rounded-full mx-auto mb-4">
                    
                    <h2 class="text-2xl font-bold text-gray-900">{{ $athlete->full_name }}</h2>
                    <p class="text-gray-600">{{ $athlete->genre }} • {{ $athlete->age }} ans</p>
                    
                    <div class="mt-4 flex justify-center space-x-2">
                        <a href="{{ route('athletes.edit', $athlete) }}" 
                           class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            <i class="bi bi-pencil mr-1"></i>Modifier
                        </a>
                        <form action="{{ route('athletes.destroy', $athlete) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="mt-6 space-y-3 border-t pt-4">
                    <div class="flex items-center text-sm">
                        <i class="bi bi-envelope text-gray-400 w-5"></i>
                        <span class="ml-2 text-gray-600">{{ $athlete->email }}</span>
                    </div>
                    <div class="flex items-center text-sm">
                        <i class="bi bi-telephone text-gray-400 w-5"></i>
                        <span class="ml-2 text-gray-600">{{ $athlete->telephone }}</span>
                    </div>
                    <div class="flex items-center text-sm">
                        <i class="bi bi-geo-alt text-gray-400 w-5"></i>
                        <span class="ml-2 text-gray-600">{{ $athlete->ville }}</span>
                    </div>
                    <div class="flex items-center text-sm">
                        <i class="bi bi-card-text text-gray-400 w-5"></i>
                        <span class="ml-2 text-gray-600">{{ $athlete->numero_certificat_handicap }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Details Sections -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Informations Physiques -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="bi bi-person-bounding-box mr-2 text-blue-600"></i>
                    Informations Physiques
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @if($athlete->taille)
                    <div class="p-3 bg-gray-50 rounded-lg">
                        <p class="text-xs text-gray-500">Taille</p>
                        <p class="text-lg font-semibold">{{ $athlete->taille }} cm</p>
                    </div>
                    @endif
                    @if($athlete->poids)
                    <div class="p-3 bg-gray-50 rounded-lg">
                        <p class="text-xs text-gray-500">Poids</p>
                        <p class="text-lg font-semibold">{{ $athlete->poids }} kg</p>
                    </div>
                    @endif
                    @if($athlete->pointure)
                    <div class="p-3 bg-gray-50 rounded-lg">
                        <p class="text-xs text-gray-500">Pointure</p>
                        <p class="text-lg font-semibold">{{ $athlete->pointure }}</p>
                    </div>
                    @endif
                    @if($athlete->taille_vestimentaire)
                    <div class="p-3 bg-gray-50 rounded-lg">
                        <p class="text-xs text-gray-500">Taille Vestimentaire</p>
                        <p class="text-lg font-semibold">{{ $athlete->taille_vestimentaire }}</p>
                    </div>
                    @endif
                    <div class="p-3 bg-gray-50 rounded-lg">
                        <p class="text-xs text-gray-500">Chaise Roulante</p>
                        <p class="text-lg font-semibold">
                            @if($athlete->chaise_roulante)
                                <span class="text-blue-600">Oui</span>
                            @else
                                <span class="text-gray-400">Non</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Activités -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="bi bi-trophy mr-2 text-blue-600"></i>
                    Activités Pratiquées
                </h3>
                <div class="space-y-4">
                    @if($athlete->activites_collectives)
                    <div>
                        <p class="text-sm font-medium text-gray-700 mb-2">Activités Collectives</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($athlete->activites_collectives as $activite)
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">{{ $activite }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    @if($athlete->activites_individuelles)
                    <div>
                        <p class="text-sm font-medium text-gray-700 mb-2">Activités Individuelles</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($athlete->activites_individuelles as $activite)
                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm">{{ $activite }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($athlete->autres_activites)
                    <div>
                        <p class="text-sm font-medium text-gray-700 mb-2">Autres Activités</p>
                        <p class="text-gray-600">{{ $athlete->autres_activites }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Contact d'Urgence -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="bi bi-exclamation-triangle mr-2 text-orange-600"></i>
                    Contact d'Urgence
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Nom Complet</p>
                        <p class="text-base font-medium">{{ $athlete->contact_prenom }} {{ $athlete->contact_nom }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="text-base font-medium">{{ $athlete->contact_email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Téléphone</p>
                        <p class="text-base font-medium">{{ $athlete->contact_telephone }}</p>
                    </div>
                </div>
            </div>

            <!-- Documents -->
            @if($athlete->certificat_handicap_path || $athlete->cin_livret_path)
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="bi bi-file-earmark-pdf mr-2 text-purple-600"></i>
                    Documents
                </h3>
                <div class="space-y-2">
                    @if($athlete->certificat_handicap_path)
                    <a href="{{ asset('storage/' . $athlete->certificat_handicap_path) }}" 
                       target="_blank"
                       class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100">
                        <div class="flex items-center">
                            <i class="bi bi-file-pdf text-red-600 text-2xl mr-3"></i>
                            <span class="text-sm font-medium">Certificat d'Handicap</span>
                        </div>
                        <i class="bi bi-download"></i>
                    </a>
                    @endif
                    
                    @if($athlete->cin_livret_path)
                    <a href="{{ asset('storage/' . $athlete->cin_livret_path) }}" 
                       target="_blank"
                       class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100">
                        <div class="flex items-center">
                            <i class="bi bi-file-pdf text-red-600 text-2xl mr-3"></i>
                            <span class="text-sm font-medium">CIN ou Livret de Famille</span>
                        </div>
                        <i class="bi bi-download"></i>
                    </a>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
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