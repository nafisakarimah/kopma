<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PenggunaController extends Controller
{
    public function index()
    {
        $data = User::where(['role' => 2])->get();

        return view('admin.pengguna.index',[
            'data' => $data,

        ]);
    }

    public function edit($id)
    {

        $data = User::findOrFail($id);

        return view('admin.pengguna.edit',[
            'data' => $data
        ]);
    }

    public function verif(Request $request, User $user)
    {
        $user->update([
            'status' => 1
        ]);
        return redirect()->route('admin.pengguna')->with('success','Berhasil memverifikasi pengguna');
    }

    public function suspen(Request $request, User $user)
    {
        $user->update([
            'status' => 2
        ]);
        return redirect()->route('admin.pengguna')->with('success','Berhasil membekukan pengguna');
    }

    public function update(Request $request,$id)
    {
        $data = User::findOrFail($id);

        $request->validate([
            'status' => 'in:0,1,2',
            'role' => 'in:customer,member'
        ]);

        $data->update([
            'member' => $request->role == 'member'? 1 : 0,
            'status' => $request->status
        ]);

        return redirect()->route('admin.pengguna')->with('success','Berhasil mengubah pengguna');

    }


}
