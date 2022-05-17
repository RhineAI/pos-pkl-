<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Satuan;
use App\Models\Produk;
use App\Models\Supplier;
use App\Models\User;
use GuzzleHttp\Promise\Create;
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
        User::Create([
            'name' => 'Administrator',
            'username' => 'administrator',
            'email' => 'administrator@gmail.com',
            'password' => bcrypt('admin123'),
            'level' => 1
        ]);



        Kategori::create([
            'nama_kategori' => 'Makanan'
        ]);

        Satuan::create([
            'nama_satuan' => 'bungkus'
        ]);

        Produk::create([
            'barcode' => 'BRC-202206001',
            'nama_produk' => 'Naspad',
            'id_kategori' => 1,
            'id_satuan' => 1,
            'harga_beli' => 10000,
            'harga_jual' => 12000,
            'diskon' => 0,
            'stok' => 10
        ]);

        Supplier::create([
            'nama' => 'Supplier1',
            'alamat' => 'Cianjur',
            'telepon' => '0123456789'
        ]);
        // \App\Models\User::factory(10)->create();
    }
}
