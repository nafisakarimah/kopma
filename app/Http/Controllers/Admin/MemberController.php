<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {

        $data = User::where(['role' => 2,'member' => 1])->get();

        return view('admin.member.index',[
            'data' => $data
        ]);
    }

    public function verif(Request $request, User $user)
    {
        $user->update([
            'status' => 1
        ]);
        return redirect()->route('admin.member')->with('success','Berhasil memverifikasi sebagai member');
    }
    
    public function unverif(Request $request, User $user)
    {
        $user->update([
            'status' => 0,
            'member' => 0
        ]);
        return redirect()->route('admin.member')->with('success','Berhasil membatalkan verifikasi sebagai member');
    }

    public function suspen(Request $request, User $user)
    {
        $user->update([
            'status' => 3
        ]);
        return redirect()->route('admin.pengguna')->with('success','Berhasil membekukan pengguna');
    }
}
