<?php

namespace App\Http\Controllers;

use App\Models\Athlete;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AthleteController extends Controller
{
    public function index()
    {
        $athletes = Athlete::latest()->paginate(15);
        return view('athletes.index', compact('athletes'));
    }

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
