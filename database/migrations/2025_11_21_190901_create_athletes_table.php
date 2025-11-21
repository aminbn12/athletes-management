<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('athletes', function (Blueprint $table) {
            $table->id();
            
            // Informations Générales
            $table->string('nom');
            $table->string('prenom');
            $table->enum('genre', ['Homme', 'Femme', 'Autre']);
            $table->string('email')->unique();
            $table->string('telephone');
            $table->date('date_naissance');
            $table->text('adresse_postale');
            $table->string('ville');
            $table->string('numero_certificat_handicap')->unique();
            $table->integer('taille')->nullable();
            $table->decimal('poids', 5, 2)->nullable();
            $table->string('lien')->nullable();
            $table->integer('pointure')->nullable();
            $table->string('taille_vestimentaire')->nullable();
            $table->boolean('chaise_roulante')->default(false);
            $table->text('allergie_alimentaire')->nullable();
            $table->text('maladie')->nullable();
            
            // Activités Pratiquées
            $table->json('activites_collectives')->nullable();
            $table->json('activites_individuelles')->nullable();
            $table->text('autres_activites')->nullable();
            
            // Personne à Contacter
            $table->string('contact_nom');
            $table->string('contact_prenom');
            $table->string('contact_email');
            $table->string('contact_telephone');
            
            // Documents
            $table->string('certificat_handicap_path')->nullable();
            $table->string('cin_livret_path')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('athletes');
    }
};