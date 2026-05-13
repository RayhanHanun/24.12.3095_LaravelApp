<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');

        Partner::truncate();

        for ($i = 0; $i < 5; $i++) {
            $name = $faker->company;
            $label = Str::of($name)->limit(12, '')->replace(' ', '+');

            Partner::create([
                'name' => $name,
                'logo_url' => "https://placehold.co/200x200?text={$label}",
            ]);
        }
    }
}
