<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Athlete extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nom', 'prenom', 'genre', 'email', 'telephone', 'date_naissance',
        'adresse_postale', 'ville', 'numero_certificat_handicap',
        'taille', 'poids', 'lien', 'pointure', 'taille_vestimentaire',
        'chaise_roulante', 'allergie_alimentaire', 'maladie',
        'activites_collectives', 'activites_individuelles', 'autres_activites',
        'contact_nom', 'contact_prenom', 'contact_email', 'contact_telephone',
        'certificat_handicap_path', 'cin_livret_path'
    ];

    protected $casts = [
        'date_naissance' => 'date',
        'chaise_roulante' => 'boolean',
        'activites_collectives' => 'array',
        'activites_individuelles' => 'array',
        'taille' => 'integer',
        'poids' => 'decimal:2',
    ];

    public function getFullNameAttribute()
    {
        return "{$this->prenom} {$this->nom}";
    }

    public function getAgeAttribute()
    {
        return $this->date_naissance->age;
    }
}