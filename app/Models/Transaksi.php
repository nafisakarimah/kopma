<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detail()
    {
        return $this->hasMany(DetailTransaksi::class);
    }

    public function pencairan_dana()
    {
        return $this->hasOne(PencairanDana::class);
    }

    public function alamat()
    {
        return $this->belongsTo(AlamatPengiriman::class,'alamat_pengiriman_id');
    }
}
