<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Athlete;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AthleteController extends Controller
{
    public function index()
    {
        $athletes = Athlete::latest()->paginate(15);
        return response()->json($athletes);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
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

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->except(['certificat_handicap', 'cin_livret']);

        // Upload files
        if ($request->hasFile('certificat_handicap')) {
            $data['certificat_handicap_path'] = $request->file('certificat_handicap')
                ->store('documents/certificats', 'public');
        }

        if ($request->hasFile('cin_livret')) {
            $data['cin_livret_path'] = $request->file('cin_livret')
                ->store('documents/cin_livrets', 'public');
        }

        $athlete = Athlete::create($data);

        return response()->json([
            'message' => 'Athlète créé avec succès',
            'athlete' => $athlete
        ], 201);
    }

    public function show(Athlete $athlete)
    {
        return response()->json($athlete);
    }

    public function update(Request $request, Athlete $athlete)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'email|unique:athletes,email,' . $athlete->id,
            'numero_certificat_handicap' => 'string|unique:athletes,numero_certificat_handicap,' . $athlete->id,
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->except(['certificat_handicap', 'cin_livret']);

        if ($request->hasFile('certificat_handicap')) {
            if ($athlete->certificat_handicap_path) {
                Storage::disk('public')->delete($athlete->certificat_handicap_path);
            }
            $data['certificat_handicap_path'] = $request->file('certificat_handicap')
                ->store('documents/certificats', 'public');
        }

        if ($request->hasFile('cin_livret')) {
            if ($athlete->cin_livret_path) {
                Storage::disk('public')->delete($athlete->cin_livret_path);
            }
            $data['cin_livret_path'] = $request->file('cin_livret')
                ->store('documents/cin_livrets', 'public');
        }

        $athlete->update($data);

        return response()->json([
            'message' => 'Athlète mis à jour avec succès',
            'athlete' => $athlete
        ]);
    }

    public function destroy(Athlete $athlete)
    {
        $athlete->delete();
        return response()->json(['message' => 'Athlète supprimé avec succès']);
    }
}
