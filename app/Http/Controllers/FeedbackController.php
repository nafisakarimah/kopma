<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function index()
    {
        if(Auth::check())
        {
            $data['feedback'] = Feedback::where(['user_id' => auth()->id()])->first();
        }else{
            $data['feedback'] = null;
        }
        $data['data'] = Feedback::where('tampil','1')->get();
        return view('feedback',$data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'masukan' => 'required'
        ]);

        Feedback::create([
            'user_id' => auth()->id(),
            'masukan' => $request->masukan
        ]); 

        return redirect()->route('feedback')->with('success','Berhasil mengirim feedback');

    }
}
