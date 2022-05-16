<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Satuan;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin123'),
            'level' => 1
        ]);

        Kategori::create([
            'nama_kategori' => 'Makanan'
        ]);

        Satuan::create([
            'nama_satuan' => 'pcs'
        ]);

        Supplier::create([
            'nama' => 'Luhung Lugina',
            'alamat' => 'JL KEMAYORAN',
            'telepon' => '082118356193'
        ]);
        // \App\Models\User::factory(10)->create();
    }
}
