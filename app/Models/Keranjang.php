<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;

    protected $table = 'keranjang';

    protected $guarded = ['id'];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function detail()
    {
        return $this->hasMany(Self::class,'penyedia_id','penyedia_id');
    }

    public function ukuran()
    {
        return $this->belongsTo(UkuranProduk::class,'ukuran_produk_id');
    }
}
