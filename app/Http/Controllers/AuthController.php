<?php

namespace App\Http\Controllers;

use App\Mail\VerifyAccount;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function register_submit(Request $request)
    {

        $request->validate([
            'nama' => 'required',
            'nak' => ($request->member == '1'? 'required' : 'nullable'),
            'no_telp' => 'required|unique:users,no_telp',
            'alamat' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $data = $request->all();

        $data['password'] = Hash::make($request->password);

        $data['role'] = 2;

        $data['status'] = 0;

        // dd($request->input());


        $sendMail = false;
        if($request->input('member') != '1')
        {
            Mail::to($request->email)->send(new VerifyAccount(md5($request->email)));
            $sendMail = true;
        }

        $sv = User::create($data);

        if($sv)
        {
            if($sendMail)
            {
                return redirect()->route('login')->with('success','Kami berhasil mengirim link verifikasi ke email '.$request->email);
            }else{
                return redirect()->route('login')->with('success','Verifikasi member sedang dalam proses, silahkan login kembali untuk melakukan order');
            }
        }

        return redirect()->route('register')->withErrors(['error' => 'Gagal mendaftar.'])->withInput();
    }


    public function login_submit(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ],[
            'username.required' => 'Email atau No HP is required',
            'password.required' => 'Passoword is required'
        ]);

        $user = User::where(['email' => $request->username])->orWhere(['no_telp' => $request->username])->first();
        if(!$user)
        {
            return redirect()->route('login')->withErrors(['error' => 'Email atau No HP atau Password yang anda masukkan salah.'])->withInput();
        }

        if(!Hash::check($request->password,$user->password))
        {
            return redirect()->route('login')->withErrors(['error' => 'Email atau No HP atau Password yang anda masukkan salah.'])->withInput();
        }

        if($user->status == '0' && $user->member == '0')
        {
            return redirect()->route('login')->withErrors(['error' => 'Akun anda belum diverifikasi.'])->withInput();
        }
        if($user->status == '3')
        {
            return redirect()->route('login')->withErrors(['error' => 'Akun anda dibekukan!'])->withInput();
        }

        Auth::login($user);

        if($user->role == '1')
        {
            return redirect()->route('admin.index')->with('success','Berhasil login');
        }elseif($user->role == '2')
        {
            return redirect()->route('home')->with('success','Berhasil login');
        }else{
            return redirect()->route('logout');
        }
    }

    public function verify($email)
    {
        $user = User::whereRaw("md5(email) = ?", [$email])->first();

        if (!$user) {
            return redirect()->route('login')->with('success', 'Akun tidak ditemukan.');
        }

        if ($user->status == 1) {
            return redirect()->route('login')->with('success', 'Akun sudah aktif, silakan login.');
        }

        $user->update([
            'status' => 1
        ]);

        return redirect()->route('login')->with('success', 'Berhasil memverifikasi akun, silakan login.');
    }


    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }
}
