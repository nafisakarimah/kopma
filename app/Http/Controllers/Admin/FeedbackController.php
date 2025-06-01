<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        $data['data'] = Feedback::all();
        return view('admin.feedback.index',$data);
    }

    public function tampilkan($id)
    {
        $feed = Feedback::findOrFail($id);
        $feed->update(['tampil' => !$feed->tampil]);
        return redirect()->route('admin.feedback.index')->with('success','Berhasil mengubah status');
    }
}
