<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function show($slug)
    {

        $data['kategori'] = Kategori::orderBy('id','desc')->get();
        $data['produk'] = Produk::where(['slug' => $slug])->firstOrFail();
        
        return view('produk',$data);
    }
    
    public function cari(Request $request)
    {
        $produk = new Produk;

        if($request->input('keyword'))
        {
            $produk = $produk->where(function($query) use ($request){
                $query->where('nama','like','%'.$request->keyword.'%')
                ->orWhere('harga','like','%'.$request->keyword.'%')
                ->orWhere('deskripsi','like','%'.$request->keyword.'%');
            });
        }

        $data['produk'] = $produk->get();
        $data['keyword'] = $request->input('keyword');

        return view('cari',$data);
    }
}
