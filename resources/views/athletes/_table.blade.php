<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">

        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Athlète</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ville</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">N° Certificat</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Activités</th>
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
                                 src="https://ui-avatars.com/api/?name={{ urlencode($athlete->nom . ' ' . $athlete->prenom) }}&background=random"
                                 alt="{{ $athlete->nom }} {{ $athlete->prenom }}">
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">{{ $athlete->nom }} {{ $athlete->prenom }}</div>
                            <div class="text-sm text-gray-500">{{ $athlete->genre }} • {{ \Carbon\Carbon::parse($athlete->date_naissance)->age ?? '-' }} ans</div>
                        </div>
                    </div>
                </td>

                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">{{ $athlete->email }}</div>
                    <div class="text-sm text-gray-500">{{ $athlete->telephone }}</div>
                </td>

                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $athlete->ville }}</td>

                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $athlete->numero_certificat_handicap }}</td>

                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    <div class="text-xs text-gray-600">
                        <div><strong>Collectives:</strong> {{ $athlete->activites_collectives ?: '-' }}</div>
                        <div><strong>Individuelles:</strong> {{ $athlete->activites_individuelles ?: '-' }}</div>
                        <div><strong>Autres:</strong> {{ $athlete->autres_activites ?: '-' }}</div>
                    </div>
                </td>

                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <button onclick="event.stopPropagation();" data-url="{{ route('athletes.edit', $athlete) }}" class="js-redirect text-blue-600 hover:text-blue-900 mr-3">
                        <i class="bi bi-pencil"></i>
                    </button>

                    <form action="{{ route('athletes.destroy', $athlete) }}" method="POST" class="inline"
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
                    <p>Aucun athlète correspondant</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination (blade) -->
<div class="mt-4">
    @if($athletes->hasPages())
    <div class="flex justify-center">
        {!! $athletes->links() !!}
    </div>
    @endif
</div>
