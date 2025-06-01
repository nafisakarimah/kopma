<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\UkuranProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Produk::all();

        return view('admin.produk.index',[
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['kategori'] = Kategori::all();
        return view('admin.produk.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required|exists:kategori,id',
            'gambar' => 'required|image|mimes:png,jpg',
            'nama' => 'required',
            'stok' => 'nullable',
            'harga' => 'required',
            'ukuran' => 'nullable|array',
            'ukuran.*.ukuran' => 'required',
            'ukuran.*.stok' => 'min:1',
            'deskripsi' => 'required',
        ]);

        $kategori = Kategori::find($request->kategori);

        if($kategori->ukuran == '1')
        {
            $request->validate([
                'kategori' => 'required|exists:kategori,id',
                'gambar' => 'required|image|mimes:png,jpg',
                'nama' => 'required',
                'stok' => 'nullable',
                'harga' => 'required',
                'ukuran' => 'required|array',
                'ukuran.*.ukuran' => 'required',
                'ukuran.*.stok' => 'min:1',
                'deskripsi' => 'required',
            ]);
        }else{
            $request->validate([
                'kategori' => 'required|exists:kategori,id',
                'gambar' => 'required|image|mimes:png,jpg',
                'nama' => 'required',
                'stok' => 'required',
                'harga' => 'required',
                'ukuran' => 'nullable|array',
                'ukuran.*.ukuran' => 'required',
                'ukuran.*.stok' => 'min:1',
                'deskripsi' => 'required',
            ]);
        }

        $path = $request->file('gambar')->store('public/produk');
        if($path)
        {
            $gambar = Storage::url($path);
        }

        $produkSv = Produk::create([
            'kategori_id' => $request->kategori,
            'gambar' => $gambar,
            'nama' => $request->nama,
            'slug' => $this->generate_slug($request->nama),
            'harga' => $request->harga,
            'stok' => $request->stok,
            'deskripsi' => $request->deskripsi
        ]);

        if($produkSv)
        {
            if($kategori->ukuran == '1')
            {
                $ukuranData = [];
                foreach($request->ukuran as $item){
                    $ukuranData[] = [
                        'produk_id' => $produkSv->id,
                        'ukuran' => $item['ukuran'],
                        'stok' => $item['stok']
                    ];
                }
                UkuranProduk::insert($ukuranData);
            }
        }

        return redirect()->route('admin.produk.index')->with('success','Berhasil menambahkan data');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Produk $produk)
    {
        $data['kategori'] = Kategori::all();
        $data['produk'] = $produk;
        return view('admin.produk.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'kategori' => 'required|exists:kategori,id',
            'gambar' => 'nullable|image|mimes:png,jpg',
            'nama' => 'required',
            'stok' => 'required',
            'harga' => 'required',
            'ukuran' => 'nullable|array',
            'ukuran.*.ukuran' => 'required',
            'ukuran.*.stok' => 'min:1',
            'deskripsi' => 'required',
        ]);

        $kategori = Kategori::find($request->kategori);

        if($kategori->ukuran == '1')
        {
            $request->validate([
                'kategori' => 'required|exists:kategori,id',
                'gambar' => 'nullable|image|mimes:png,jpg',
                'nama' => 'required',
                'stok' => 'required',
                'harga' => 'required',
                'ukuran' => 'required|array',
                'ukuran.*.ukuran' => 'required',
                'ukuran.*.stok' => 'min:1',
                'deskripsi' => 'required',
            ]);
        }
        
        $gambar = $produk->gambar;

        if($request->file('gambar'))
        {
            $request->validate([
                'gambar' => 'required|image|mimes:png,jpg',
            ]);
            $path = $request->file('gambar')->store('public/produk');
            if($path)
            {
                $gambar = Storage::url($path);
            }
        }

        $produk->update([
            'kategori_id' => $request->kategori,
            'gambar' => $gambar,
            'nama' => $request->nama,
            'slug' => $this->generate_slug($request->nama),
            'harga' => $request->harga,
            'ukuran' => $request->ukuran,
            'stok' => $request->stok,
            'deskripsi' => $request->deskripsi
        ]);

        if($kategori->ukuran == '1')
        {
            $ukuran = UkuranProduk::where(['produk_id' => $produk->id])->delete();
            $ukuranData = [];
            foreach($request->ukuran as $item){
                $ukuranData[] = [
                    'produk_id' => $produk->id,
                    'ukuran' => $item['ukuran'],
                    'stok' => $item['stok']
                ];
            }
            UkuranProduk::insert($ukuranData);
        }

        return redirect()->route('admin.produk.index')->with('success','Berhasil mengubah data');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produk $produk)
    {
        $produk->delete();
        return redirect()->route('admin.produk.index')->with('success','Berhasil menghapus data');

    }

    public function generate_slug($nama)
    {
        $produk_count = Produk::where(['nama' => $nama])->count();
        if($produk_count > 0)
        {
            return Str::slug($nama.'-'.$produk_count);
        }
        return Str::slug($nama);
    }
}
