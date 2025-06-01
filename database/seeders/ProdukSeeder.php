<?php

namespace Database\Seeders;

use App\Models\Produk;
use App\Models\UkuranProduk;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $produk = Produk::create(
            [
                'kategori_id' => 1,
                'gambar' => '/assets/img/product-2.jpg',
                'nama' => 'Produk 1',
                'slug' => 'produk-1',
                'harga' => 90000,
                'stok' => null,
                'deskripsi' => 'Deskripsi'
            ]
        );
        UkuranProduk::insert([
            [
                'produk_id' => $produk->id,
                'ukuran' => 'S',
                'stok' => 10
            ],
            [
                'produk_id' => $produk->id,
                'ukuran' => 'M',
                'stok' => 10
            ],
            [
                'produk_id' => $produk->id,
                'ukuran' => 'L',
                'stok' => 10
            ],
            [
                'produk_id' => $produk->id,
                'ukuran' => 'XL',
                'stok' => 10
            ],
            [
                'produk_id' => $produk->id,
                'ukuran' => 'XXL',
                'stok' => 10
            ],
        ]);


        $produk2 = Produk::create(
            [
                'kategori_id' => 1,
                'gambar' => '/assets/img/product-7.jpg',
                'nama' => 'Produk 2',
                'slug' => 'produk-2',
                'harga' => 79000,
                'stok' => null,
                'deskripsi' => 'Deskripsi'
            ]
        );
        UkuranProduk::insert([
            [
                'produk_id' => $produk2->id,
                'ukuran' => 'S',
                'stok' => 10
            ],
            [
                'produk_id' => $produk2->id,
                'ukuran' => 'M',
                'stok' => 10
            ],
            [
                'produk_id' => $produk2->id,
                'ukuran' => 'L',
                'stok' => 10
            ],
            [
                'produk_id' => $produk2->id,
                'ukuran' => 'XL',
                'stok' => 10
            ],
            [
                'produk_id' => $produk2->id,
                'ukuran' => 'XXL',
                'stok' => 10
            ],
        ]);
        
        
        $produk3 = Produk::create(
            [
                'kategori_id' => 2,
                'gambar' => '/assets/img/product-1.jpg',
                'nama' => 'Produk 3',
                'slug' => 'produk-3',
                'harga' => 79000,
                'stok' => 80,
                'deskripsi' => 'Deskripsi'
            ]
        );
        $produk3 = Produk::create(
            [
                'kategori_id' => 2,
                'gambar' => '/assets/img/product-3.jpg',
                'nama' => 'Produk 4',
                'slug' => 'produk-4',
                'harga' => 50000,
                'stok' => 70,
                'deskripsi' => 'Deskripsi'
            ]
        );
    }
}
