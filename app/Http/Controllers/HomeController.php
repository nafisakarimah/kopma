<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Guskom;
use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $data['produk'] = Produk::all();
        $data['kategori'] = Kategori::orderBy('id','desc')->get();
        $data['guskom'] = Guskom::all();
        $data['feedback'] = Feedback::where('tampil','1')->get();
        return view('home',$data);
    }

    public function kategori(Request $request,$slug)
    {
        $produk = Produk::whereRelation('kategori','slug',$slug);
        // $data['detail'] = Kategori::where(['slug' => $slug])->firstOrFail();
        $data['kategori'] = Kategori::orderBy('id','desc')->get();
        if($request->input('cari'))
        {
            $produk = $produk->where(function($query) use ($request){
                $query->where('nama','like',"%$request->cari%");
            });
        }
        $data['produk'] = $produk->get();
        $data['slug_kategori'] = $slug;
        $data['cari'] = $request->input('cari');
        return view('kategori',$data);
    }
}
