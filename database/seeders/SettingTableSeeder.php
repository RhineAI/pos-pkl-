<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('setting')->insert([
            'id_setting' => 1,
            'nama_perusahaan' => 'Madtive Store',
            'alamat' => 'Jl.Mayor Harun Kabir, Bojong Herang, Kec. Cianjur, Kab. Cianjur, Jawa Barat 43216',
            'telepon' => '087836370765',
            'tipe_nota' => 1, //kecil
            'path_logo' => '/images/monster.png',
            'barcode' => 'MS-'
        ]);
    }
}
