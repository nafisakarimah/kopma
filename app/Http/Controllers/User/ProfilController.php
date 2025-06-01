<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function index()
    {
        $data['data'] = User::find(auth()->id());
        return view('user.profil',$data);
    }

    public function update_foto(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:png,jpg'
        ]);

        $foto = auth()->user()->foto;

        $path = $request->file('foto')->store('public/foto');
        if($path)
        {
            $foto = Storage::url($path);
        }

        User::find(auth()->id())->update([
            'foto' => $foto
        ]);

        return redirect()->route('user.profil.index')->with('succes','Berhasil mengubah foto');

    }

    public function update(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nak' => 'nullable',
            'no_telp' => 'required',
            'alamat' => 'required',
            'password' => 'nullable|min:6',
        ]);


        $user = User::find(auth()->id());
        
        $user->update([
            'nama' => $request->nama,
            'nak' => $request->nak,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'password' => $request->password? Hash::make($request->password) : $user->password,
        ]);

        return redirect()->route('user.profil.index')->with('succes','Berhasil mengubah profil');


    }

    public function ubahNak(Request $request)
    {
        $request->validate([
            'nak' => 'required'
        ]);

        $user = User::findOrFail(auth()->id());

        $user->update([
            'nak' => $request->nak,
            'member' => '1',
            'status' => 0
        ]);

        return redirect()->route('user.profil.index')->with('succes','Berhasil mengirim NAK mohon menunggu di verifikasi');


    }
}
