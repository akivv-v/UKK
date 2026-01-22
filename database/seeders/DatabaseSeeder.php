<?php

namespace Database\Seeders;

use App\Models\OngkosKirim;
use App\Models\Penjual;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Import Hash!

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        // Seeders
        $this->call([
            UserSeeder::class,
            ProdukSeeder::class,
        ]);

        // Ongkir
        OngkosKirim::create(['daerah' => 'Dalam Kota', 'biaya' => 10000]);
        OngkosKirim::create(['daerah' => 'Luar Kota', 'biaya' => 20000]);
        OngkosKirim::create(['daerah' => 'Luar Pulau', 'biaya' => 50000]);
    }
}
