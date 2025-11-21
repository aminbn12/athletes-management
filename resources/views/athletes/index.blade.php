@extends('layouts.app')

@section('title', 'Liste des Athlètes')
@section('page-title', 'Athlètes')
@section('page-description', 'Gérer les athlètes inscrits')

@section('content')
<div class="space-y-6">
    <!-- Actions Header -->
    <div class="flex justify-between items-center">
        <div class="flex space-x-2">
                <button data-url="{{ route('athletes.index') }}" class="js-redirect" 
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="bi bi-list-ul mr-2"></i>Liste des Athlètes
            </button>
            <button data-url="{{ route('athletes.create') }}" class="js-redirect px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                <i class="bi bi-plus-circle mr-2"></i>Nouveau Athlète
            </button>
        </div>
        
        <div class="flex space-x-2">
            <input type="text" placeholder="Rechercher..." 
                   class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <button class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                <i class="bi bi-funnel"></i>
            </button>
        </div>
    </div>

    <!-- Athletes Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Athlète</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ville</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">N° Certificat</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($athletes as $athlete)
                <tr class="hover:bg-gray-50 transition cursor-pointer clickable-row" data-url="{{ route('athletes.show', $athlete) }}">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <img class="h-10 w-10 rounded-full" 
                                     src="https://ui-avatars.com/api/?name={{ urlencode($athlete->full_name) }}&background=random" 
                                     alt="{{ $athlete->full_name }}">
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $athlete->full_name }}</div>
                                <div class="text-sm text-gray-500">{{ $athlete->genre }} • {{ $athlete->age }} ans</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $athlete->email }}</div>
                        <div class="text-sm text-gray-500">{{ $athlete->telephone }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $athlete->ville }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $athlete->numero_certificat_handicap }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            Actif
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <button onclick="event.stopPropagation();" data-url="{{ route('athletes.edit', $athlete) }}" class="js-redirect text-blue-600 hover:text-blue-900 mr-3">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <form action="{{ route('athletes.destroy', $athlete) }}" 
                              method="POST" class="inline" 
                              onsubmit="event.stopPropagation(); return confirm('Êtes-vous sûr ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                        <i class="bi bi-inbox text-4xl mb-2"></i>
                        <p>Aucun athlète enregistré</p>
                        <a href="{{ route('athletes.create') }}" class="text-blue-600 hover:underline mt-2 inline-block">
                            Créer le premier athlète
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($athletes->hasPages())
    <div class="flex justify-center">
        {{ $athletes->links() }}
    </div>
    @endif
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
        document.querySelectorAll('.clickable-row').forEach(function(row){
            row.addEventListener('click', function(e){
                var url = this.getAttribute('data-url');
                if(url) window.location.href = url;
            });
        });
    });
    </script>
    @endsection
