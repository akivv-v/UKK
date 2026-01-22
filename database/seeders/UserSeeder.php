<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            // 1. Create Fixed Admin
            \App\Models\Penjual::create([
                'username' => 'admin',
                'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
                'nama_user' => 'Administrator',
                'alamat' => 'Toko Pusat',
                'no_hp' => '081234567890',
                'role' => 'Admin'
            ]);

            // 2. Create Fixed Seller (Pemilik Toko)
            \App\Models\Penjual::create([
                'username' => 'seller',
                'password' => \Illuminate\Support\Facades\Hash::make('seller123'),
                'nama_user' => 'Pemilik Toko',
                'alamat' => 'Toko Cabang',
                'no_hp' => '081234567891',
                'role' => 'Pemilik Toko'
            ]);

            // 3. Create Fixed Customer
            \App\Models\Pelanggan::create([
                'username' => 'user',
                'password' => \Illuminate\Support\Facades\Hash::make('user123'),
                'nama_pelanggan' => 'Pelanggan Tetap',
                'alamat' => 'Alamat Pelanggan',
                'no_hp' => '089876543210',
            ]);

            // 4. Create Random Customers (e.g., 10)
            \App\Models\Pelanggan::factory(10)->create();
        } catch (\Exception $e) {
            echo "UserSeeder Error: " . $e->getMessage() . "\n";
            throw $e;
        }
    }
}
