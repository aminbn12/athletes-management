<?php

namespace App\Http\Controllers;

use App\Models\Athlete;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AthleteController extends Controller
{
    // Affiche la page principale (charge les premiers résultats)
    public function index(Request $request)
    {
        // On conserve la même logique de recherche/pagination que pour l'endpoint AJAX :
        $athletes = $this->buildQuery($request)->latest()->paginate(10)->appends($request->query());

        // Pour les filtres (listes déroulantes) : valeurs distinctes
        $villes = Athlete::select('ville')->distinct()->pluck('ville')->filter()->values();
        $genres = Athlete::select('genre')->distinct()->pluck('genre')->filter()->values();

        return view('athletes.index', compact('athletes', 'villes', 'genres'));
    }

    // Endpoint AJAX qui renvoie uniquement la partial du tableau
    public function search(Request $request)
    {
        $athletes = $this->buildQuery($request)->latest()->paginate(10)->appends($request->query());

        // Si la requête est AJAX, on renvoie le HTML de la partial
        if ($request->ajax()) {
            $html = view('athletes._table', compact('athletes'))->render();
            return response()->json(['html' => $html]);
        }

        // Fallback (si on accède directement) : retourne la vue index complète
        $villes = Athlete::select('ville')->distinct()->pluck('ville')->filter()->values();
        $genres = Athlete::select('genre')->distinct()->pluck('genre')->filter()->values();

        return view('athletes.index', compact('athletes', 'villes', 'genres'));
    }

    // Méthode réutilisée pour construire la query selon les filtres
    protected function buildQuery(Request $request)
    {
        $query = Athlete::query();

        // Recherche texte globale (search)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('telephone', 'like', "%{$search}%")
                  ->orWhere('ville', 'like', "%{$search}%")
                  ->orWhere('numero_certificat_handicap', 'like', "%{$search}%");
            });
        }

        // Filtres spécifiques
        if ($request->filled('nom')) {
            $query->where('nom', 'like', '%' . $request->input('nom') . '%');
        }

        if ($request->filled('prenom')) {
            $query->where('prenom', 'like', '%' . $request->input('prenom') . '%');
        }

        if ($request->filled('genre')) {
            $query->where('genre', $request->input('genre'));
        }

        if ($request->filled('ville')) {
            $query->where('ville', $request->input('ville'));
        }

        if ($request->filled('activites_collectives')) {
            $query->where('activites_collectives', 'like', '%' . $request->input('activites_collectives') . '%');
        }

        if ($request->filled('activites_individuelles')) {
            $query->where('activites_individuelles', 'like', '%' . $request->input('activites_individuelles') . '%');
        }

        if ($request->filled('autres_activites')) {
            $query->where('autres_activites', 'like', '%' . $request->input('autres_activites') . '%');
        }

        return $query;
    }

    // --- Les autres méthodes CRUD restent inchangées (store, create, show, edit, update, destroy)
    public function create()
    {
        return view('athletes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'genre' => 'required|in:Homme,Femme,Autre',
            'email' => 'required|email|unique:athletes,email',
            'telephone' => 'required|string',
            'date_naissance' => 'required|date',
            'adresse_postale' => 'required|string',
            'ville' => 'required|string',
            'numero_certificat_handicap' => 'required|string|unique:athletes,numero_certificat_handicap',
            'contact_nom' => 'required|string',
            'contact_prenom' => 'required|string',
            'contact_email' => 'required|email',
            'contact_telephone' => 'required|string',
            'certificat_handicap' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'cin_livret' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('certificat_handicap')) {
            $validated['certificat_handicap_path'] = $request->file('certificat_handicap')
                ->store('documents/certificats', 'public');
        }

        if ($request->hasFile('cin_livret')) {
            $validated['cin_livret_path'] = $request->file('cin_livret')
                ->store('documents/cin_livrets', 'public');
        }

        Athlete::create($validated);

        return redirect()->route('athletes.index')
            ->with('success', 'Athlète créé avec succès!');
    }

    public function show(Athlete $athlete)
    {
        return view('athletes.show', compact('athlete'));
    }

    public function edit(Athlete $athlete)
    {
        return view('athletes.edit', compact('athlete'));
    }

    public function update(Request $request, Athlete $athlete)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'genre' => 'required|in:Homme,Femme,Autre',
            'email' => 'required|email|unique:athletes,email,' . $athlete->id,
            'telephone' => 'required|string',
            'date_naissance' => 'required|date',
            'adresse_postale' => 'required|string',
            'ville' => 'required|string',
            'numero_certificat_handicap' => 'required|string|unique:athletes,numero_certificat_handicap,' . $athlete->id,
            'contact_nom' => 'required|string',
            'contact_prenom' => 'required|string',
            'contact_email' => 'required|email',
            'contact_telephone' => 'required|string',
            'certificat_handicap' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'cin_livret' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('certificat_handicap')) {
            if ($athlete->certificat_handicap_path) {
                Storage::disk('public')->delete($athlete->certificat_handicap_path);
            }
            $validated['certificat_handicap_path'] = $request->file('certificat_handicap')
                ->store('documents/certificats', 'public');
        }

        if ($request->hasFile('cin_livret')) {
            if ($athlete->cin_livret_path) {
                Storage::disk('public')->delete($athlete->cin_livret_path);
            }
            $validated['cin_livret_path'] = $request->file('cin_livret')
                ->store('documents/cin_livrets', 'public');
        }

        $athlete->update($validated);

        return redirect()->route('athletes.show', $athlete)
            ->with('success', 'Athlète mis à jour avec succès!');
    }

    public function destroy(Athlete $athlete)
    {
        if ($athlete->certificat_handicap_path) {
            Storage::disk('public')->delete($athlete->certificat_handicap_path);
        }
        if ($athlete->cin_livret_path) {
            Storage::disk('public')->delete($athlete->cin_livret_path);
        }

        $athlete->delete();

        return redirect()->route('athletes.index')
            ->with('success', 'Athlète supprimé avec succès!');
    }
}
