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
        // Ambil kategori lebih awal untuk digunakan dalam validasi dinamis
        $kategori = Kategori::findOrFail($request->kategori);

        // Aturan validasi dasar
        $rules = [
            'kategori' => 'required|exists:kategori,id',
            'gambar' => 'required|image',
            'nama' => 'required',
            'harga' => 'required',
            'deskripsi' => 'required',
        ];

        // Tambahan aturan validasi berdasarkan kategori
        if ($kategori->ukuran == '1') {
            $rules['ukuran'] = 'required|array';
            $rules['ukuran.*.ukuran'] = 'required';
            $rules['ukuran.*.stok'] = 'required|numeric|min:1';
        } else {
            $rules['stok'] = 'required|numeric|min:0';
        }

        // Jalankan validasi
        $validated = $request->validate($rules);

        // Handle upload gambar
        $gambarPath = 'assets/img/default.jpg';

        if($request->hasFile('gambar'))
        {
            $folder = 'gambar';
            $file = $request->file('gambar');
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $newName = 'IMG-' . DATE("Ymd") . '-' . time();
            $newNameWithExtension = $newName . '.' . $extension;

            $upload = $file->move(base_path('/public/uploads/' . $folder), $newNameWithExtension);

            $gambarPath = $folder . '/' . $newNameWithExtension;
        }


        // Simpan produk
        $produk = Produk::create([
            'kategori_id' => $request->kategori,
            'gambar' => $gambarPath,
            'nama' => $request->nama,
            'slug' => $this->generate_slug($request->nama),
            'harga' => $request->harga,
            'stok' => $kategori->ukuran == '1' ? null : $request->stok,
            'deskripsi' => $request->deskripsi,
        ]);

        // Simpan ukuran jika kategori menggunakan ukuran
        if ($kategori->ukuran == '1' && $request->has('ukuran')) {
            $ukuranData = collect($request->ukuran)->map(function ($item) use ($produk) {
                return [
                    'produk_id' => $produk->id,
                    'ukuran' => $item['ukuran'],
                    'stok' => $item['stok']
                ];
            })->toArray();

            UkuranProduk::insert($ukuranData);
        }

        return redirect()->route('admin.produk.index')->with('success', 'Berhasil menambahkan data');
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
        // dd("update");
        $request->validate([
            'kategori' => 'required|exists:kategori,id',
            'gambar' => 'nullable|image',
            'nama' => 'required',
            'stok' => 'required',
            'harga' => 'required',
            'ukuran' => 'nullable|array',
            'ukuran.*.ukuran' => 'required',
            'ukuran.*.stok' => 'min:1',
            'deskripsi' => 'required',
        ]);
        // dd($request->all());

        $kategori = Kategori::find($request->kategori);

        if($kategori->ukuran == '1')
        {
            $request->validate([
                'kategori' => 'required|exists:kategori,id',
                'gambar' => 'nullable|image|mimes:png,jpg',
                'nama' => 'required',
                'harga' => 'required',
                'ukuran' => 'required|array',
                'ukuran.*.ukuran' => 'required',
                'ukuran.*.stok' => 'min:1',
                'deskripsi' => 'required',
            ]);
        }

        $gambar = $produk->gambar;

        if($request->hasFile('gambar'))
        {
            $folder = 'gambar';
            $file = $request->file('gambar');
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $newName = 'IMG-' . DATE("Ymd") . '-' . time();
            $newNameWithExtension = $newName . '.' . $extension;

            $upload = $file->move(base_path('/public/uploads/' . $folder), $newNameWithExtension);

            $gambar = $folder . '/' . $newNameWithExtension;
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
