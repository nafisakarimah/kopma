<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TransaksiController extends Controller
{

    public function index(Request $request)
    {
        $data = Transaksi::where(['user_id' => auth()->id()]);
        
        if($request->input('status') != '')
        {
            $data = $data->where('status',$request->status);
        }
        
        $data = $data->orderBy('created_at','desc')->get();

        return view('user.transaksi.index',[
            'data' => $data
        ]);
    }
    
    public function show(Transaksi $transaksi)
    {
        return view('user.transaksi.show',[
            'transaksi' => $transaksi
        ]);
    }
}
