<?php

namespace Database\Seeders;

use App\Models\Athlete;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class AthleteSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('fr_FR');

        for ($i = 0; $i < 100; $i++) {

            Athlete::create([
                'nom'                       => $faker->lastName,
                'prenom'                    => $faker->firstName,
                'genre'                     => $faker->randomElement(['Homme', 'Femme']),
                'email'                     => $faker->unique()->email,
                'telephone'                 => $faker->phoneNumber,
                'date_naissance'            => $faker->date(),
                'adresse_postale'           => $faker->address,
                'ville'                     => $faker->city,
                'numero_certificat_handicap'=> $faker->numberBetween(10000, 99999),
                'taille'                    => $faker->numberBetween(140, 200),
                'poids'                     => $faker->numberBetween(40, 120),
                'lien'                      => $faker->url,
                'pointure'                  => $faker->numberBetween(35, 48),
                'taille_vestimentaire'      => $faker->randomElement(['S', 'M', 'L', 'XL', 'XXL']),
                'chaise_roulante'           => $faker->boolean(),
                'allergie_alimentaire'      => $faker->randomElement(['Aucune', 'Fruits', 'Arachides', 'Gluten', 'Lait']),
                'maladie'                   => $faker->randomElement(['Aucune', 'Asthme', 'Diabète', 'Cardiaque']),
                'activites_collectives'     => $faker->randomElement(['Football', 'Basketball', 'Handball', 'Volley']),
                'activites_individuelles'   => $faker->randomElement(['Athlétisme', 'Natation', 'Tennis', 'Judo']),
                'autres_activites'          => $faker->randomElement(['Yoga', 'Danse', 'Musculation', '']),
                'contact_nom'               => $faker->lastName,
                'contact_prenom'            => $faker->firstName,
                'contact_email'             => $faker->email,
                'contact_telephone'         => $faker->phoneNumber,
                'certificat_handicap_path'  => null,
                'cin_livret_path'           => null,
            ]);
        }
    }
}
