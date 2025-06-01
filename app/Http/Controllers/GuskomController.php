<?php

namespace App\Http\Controllers;

use App\Models\Guskom;
use Illuminate\Http\Request;

class GuskomController extends Controller
{

    public function index()
    {
        $data['data'] = Guskom::all();
        return view('guskom',$data);
    }

    public function show($slug)
    {
        $data['data'] = Guskom::where(['slug' => $slug])->firstOrFail();
        $data['lainnya'] = Guskom::where('slug','!=',$slug)->get();
        return view('guskom-detail',$data);
    }
}
