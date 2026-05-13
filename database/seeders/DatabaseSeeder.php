<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Event;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Amikom',
            'email' => 'admin@amikom.ac.id',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $catTech = Category::firstOrCreate([
            'name' => 'Teknologi & Desain',
            'slug' => 'teknologi-desain',
        ]);

        $catEntertainment = Category::firstOrCreate([
            'name' => 'Hiburan & Seni',
            'slug' => 'hiburan-seni',
        ]);

        $catEsports = Category::firstOrCreate([
            'name' => 'Olahraga & E-Sports',
            'slug' => 'olahraga-esports',
        ]);


        Event::create([
            'category_id' => $catTech->id,
            'title' => 'UI/UX Masterclass 2026',
            'description' => 'Pelajari rahasia membangun antarmuka pengguna yang intuitif dan pengalaman pengguna yang luar biasa dari para ahli industri.',
            'date' => '2026-06-15 09:00:00',
            'location' => 'Ruang Citra 1, Amikom',
            'price' => 75000,
            'stock' => 50,
            'poster_path' => 'posters/uiux-masterclass.png',
        ]);

        Event::create([
            'category_id' => $catTech->id,
            'title' => 'Laravel & React Bootcamp',
            'description' => 'Workshop intensif 2 hari membangun aplikasi web modern menggunakan Laravel 11 dan React JS.',
            'date' => '2026-07-10 08:00:00',
            'location' => 'Laboratorium Komputer 4',
            'price' => 150000,
            'stock' => 40,
            'poster_path' => 'posters/laravel-bootcamp.png',
        ]);

        Event::create([
            'category_id' => $catEntertainment->id,
            'title' => 'Amikom Jazz Night 2026',
            'description' => 'Nikmati malam yang indah dengan alunan musik jazz merdu dari band-band lokal terbaik Yogyakarta.',
            'date' => '2026-05-10 19:00:00',
            'location' => 'Amikom Baru (Area Parkir Terpadu)',
            'price' => 50000,
            'stock' => 200,
            'poster_path' => 'posters/jazz-night.png',
        ]);

        Event::create([
            'category_id' => $catEntertainment->id,
            'title' => 'Standup Comedy Campus Tour',
            'description' => 'Siapkan tawa terbaikmu! Komika papan atas akan menghibur dan mengocok perut mahasiswa.',
            'date' => '2026-05-20 18:30:00',
            'location' => 'Cinema Unit 6',
            'price' => 35000,
            'stock' => 150,
            'poster_path' => 'posters/standup-comedy.png',
        ]);

        Event::create([
            'category_id' => $catEsports->id,
            'title' => 'E-Sport U-Champ: Mobile Legends',
            'description' => 'Turnamen Mobile Legends terbesar antar universitas se-Yogyakarta. Buktikan timmu adalah yang terbaik!',
            'date' => '2026-06-01 10:00:00',
            'location' => 'Gedung BSC Lt. 1',
            'price' => 100000,
            'stock' => 32,
            'poster_path' => 'posters/mlbb-tournament.png',
        ]);

        Event::create([
            'category_id' => $catEsports->id,
            'title' => 'Valorant Campus Rumble',
            'description' => 'Adu mekanik dan strategi di turnamen Valorant kampus. Rebut total hadiah puluhan juta rupiah!',
            'date' => '2026-06-05 09:00:00',
            'location' => 'Gedung BSC Lt. 2',
            'price' => 120000, 
            'stock' => 16,
            'poster_path' => 'posters/valorant-rumble.png',
        ]);
    }
}
