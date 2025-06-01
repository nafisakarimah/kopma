<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guskom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GuskomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Guskom::all();

        return view('admin.guskom.index',[
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
        return view('admin.guskom.create');
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
            'gambar' => 'required|image|mimes:png,jpg',
            'nama' => 'required',
            'deskripsi' => 'required',
        ]);

        $uploadfile = 'assets/img/default.jpg';
        if($request->hasFile('gambar'))
        {
            $folder = 'guskom';
            $file = $request->file('gambar');
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $newName = 'IMG-' . DATE("Ymd") . '-' . time();
            $newNameWithExtension = $newName . '.' . $extension;

            $upload = $file->move(base_path('/public/uploads/' . $folder), $newNameWithExtension);

            $uploadfile = $folder . '/' . $newNameWithExtension;
        }

        $guskomSv = Guskom::create([
            'gambar' => $uploadfile,
            'nama' => $request->nama,
            'slug' => $this->generate_slug($request->nama),
            'deskripsi' => $request->deskripsi
        ]);

        return redirect()->route('admin.guskom.index')->with('success','Berhasil menambahkan data');

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
    public function edit(Guskom $guskom)
    {
        $data['guskom'] = $guskom;
        return view('admin.guskom.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Guskom $guskom)
    {
        $request->validate([
            'gambar' => 'nullable|image|mimes:png,jpg',
            'nama' => 'required',
            'deskripsi' => 'required',
        ]);

        $uploadfile = $request->gambar_old;
        if($request->hasFile('gambar'))
        {
            $folder = 'guskom';
            $file = $request->file('gambar');
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $newName = 'IMG-' . DATE("Ymd") . '-' . time();
            $newNameWithExtension = $newName . '.' . $extension;

            $upload = $file->move(base_path('/public/uploads/' . $folder), $newNameWithExtension);

            $uploadfile = $folder . '/' . $newNameWithExtension;
        }

        $guskom->update([
            'gambar' => $uploadfile,
            'nama' => $request->nama,
            'slug' => $this->generate_slug($request->nama),
            'deskripsi' => $request->deskripsi
        ]);

        return redirect()->route('admin.guskom.index')->with('success','Berhasil mengubah data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Guskom $guskom)
    {
        $guskom->delete();
        return redirect()->route('admin.guskom.index')->with('success','Berhasil menghapus data');

    }

    public function generate_slug($nama)
    {
        $guskom_count = Guskom::where(['nama' => $nama])->count();
        if($guskom_count > 0)
        {
            return Str::slug($nama.'-'.$guskom_count);
        }
        return Str::slug($nama);
    }
}
