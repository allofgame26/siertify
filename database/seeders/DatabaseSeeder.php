<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            idetitasseeder::class,
            jenispenggunaseeder::class,
            periodeseeder::class,
            bidangminatseeder::class,
            matakuliahseeder::class,
            vendorpelatihanseeder::class,
            vendorsertifikasiseeder::class,
            jenispelatihansertifikasiseeder::class,
        ]);
    }
}
