<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index()
    {
        return view('panel.login');
    }

    public function check(Request $request)
    {
        $username = $request->nama_pengguna;
        $password = $request->kata_sandi;
        $data = User::where('username', $username)->first();
        if ($data && Hash::check($password, $data->password)) {
            Session::put('user_id', $data->id);
            Session::put('name', $data->name);
            Session::put('username', $data->username);
            Session::put('level', $data->level);
            Session::put('is_online', TRUE);
            return redirect()->route('dashboard')
                ->with('alert', "Berhasil masuk sebagai level $data->level.")
                ->with('type', 'success');
        }else{
            return redirect()->back()
                ->with('alert', 'Nama Pengguna atau Kata Sandi yang anda masukan tidak cocok.')
                ->with('type', 'danger');
        }
    }
    
    public function destroy(){
        Session::flush();
        return redirect()->route('login')
            ->with('alert', 'Berhasil keluar akun')
            ->with('type', 'success');
    }
}
