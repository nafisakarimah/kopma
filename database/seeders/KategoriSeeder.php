<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Kategori::insert([
            [
                'nama' => 'Gamashirt',
                'slug' => 'gamashirt',
                'ukuran' => 1
            ],
            [
                'nama' => 'Swalayan',
                'slug' => 'swalayan',
                'ukuran' => 0
            ]
            ]);
    }
}
