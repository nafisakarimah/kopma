<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $data['data'] = Faq::orderBy('urutan','asc')->get();
        return view('faq',$data);
    }
}
