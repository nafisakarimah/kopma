<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AlamatPengiriman;
use Illuminate\Http\Request;

class AlamatPengirimanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['data'] = AlamatPengiriman::where(['user_id' => auth()->id()])->get();
        return view('user.alamat-pengiriman.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.alamat-pengiriman.create');
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
            'nama' => 'required',
            'no_telp' => 'required',
            'alamat' => 'required'
        ]);

        $utama = 0;

        if(AlamatPengiriman::where(['user_id' => auth()->id()])->count() == 0)
        {
            $utama = 1;
        }

        AlamatPengiriman::create([
            'user_id' => auth()->id(),
            'nama' => $request->nama,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'utama' => $utama
        ]);

        return redirect()->route('user.alamat-pengiriman.index')->with('success','Berhasil menambahkan alamat pengiriman');

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
    public function edit(AlamatPengiriman $alamatPengiriman)
    {
        $data['detail'] = $alamatPengiriman;
        return view('user.alamat-pengiriman.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AlamatPengiriman $alamatPengiriman)
    {
        $request->validate([
            'nama' => 'required',
            'no_telp' => 'required',
            'alamat' => 'required'
        ]);

        $alamatPengiriman->update([
            'user_id' => auth()->id(),
            'nama' => $request->nama,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('user.alamat-pengiriman.index')->with('success','Berhasil mengubah alamat pengiriman');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AlamatPengiriman $alamatPengiriman)
    {

        $alamatPengiriman->delete();

        return redirect()->route('user.alamat-pengiriman.index')->with('success','Berhasil menghapus alamat pengiriman');
    }
    
    public function set_utama($id)
    {
        $alamat = AlamatPengiriman::findOrFail($id);
        AlamatPengiriman::where(['user_id' => auth()->id()])->update(['utama' => 0]);
        
        $alamat->update([
            'utama' => 1
        ]);
        
        return redirect()->route('user.alamat-pengiriman.index')->with('success','Berhasil menjadikan utama alamat pengiriman');

    }
}
