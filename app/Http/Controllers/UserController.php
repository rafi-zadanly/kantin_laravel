<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\notInNull;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected $defaultRedirect = "user.index";

    public function index()
    {
        $data = [
            'page' => 'Pengguna',
            'users' => User::all(),
        ];
        return view('panel.user.index', $data);
    }

    public function create()
    {
        $data = [
            'page' => 'Pengguna',
        ];
        return view('panel.user.create', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => ['required', 'min:3', 'max:100'],
            'nama_pengguna' => ['required', 'min:3', 'max:50', 'unique:users,username'],
            'kata_sandi' => ['required', 'min:3', 'max:25'],
            'tingkat_pengguna' => new notInNull,
        ], $this->message);

        if($validator->fails()){
            return $this->validate_fails($validator);
        }else{
            $data = new User();
            $data->name = $request->nama_lengkap;
            $data->username = $request->nama_pengguna;
            $data->password = Hash::make($request->kata_sandi);
            $data->level = $request->tingkat_pengguna;
            if ($data->save()) {
                return $this->success_redirect("Berhasil menambahkan pengguna.", $this->defaultRedirect);
            }else{
                return $this->error_redirect();
            }
        }
    }

    public function show(User $user)
    {
        //
    }

    public function edit(User $user)
    {
        $data = [
            'page' => 'Pengguna',
            'user' => $user,
        ];
        return view('panel.user.edit', $data);
    }

    public function update(Request $request, User $user)
    {
        $validate = [
            'nama_lengkap' => ['required', 'min:3', 'max:100'],
            'nama_pengguna' => ['required', 'min:3', 'max:50'],
            'tingkat_pengguna' => new notInNull,
        ];
        $request->hidden_nama_pengguna != $request->nama_pengguna ? 
        $validate['nama_pengguna'] = ['required', 'min:3', 'max:50', 'unique:users,username'] : '';
        
        $request->kata_sandi != "" ?
        $valid['kata_sandi'] = ['required', 'min:3', 'max:25'] : '';
        
        $validator = Validator::make($request->all(), $validate, $this->message);
        
        if($validator->fails()){
            return $this->validate_fails($validator);
        }else{
            $update = [
                'name' => $request->nama_lengkap,
                'username' => $request->nama_pengguna,
                'level' => $request->tingkat_pengguna,
            ];
            $request->kata_sandi != "" ? $update['password'] = Hash::make($request->kata_sandi) : '';
            if ($user->update($update)) {
                return $this->success_redirect("Berhasil mengubah pengguna dengan nama $user->name.", $this->defaultRedirect);
            }else{
                return $this->error_redirect();
            }
        }
    }

    public function destroy(User $user)
    {
        if ($user->delete()) {
            return $this->success_redirect("Berhasil menghapus pengguna dengan nama $user->name.", $this->defaultRedirect);
        }else{
            return $this->error_redirect();
        }
    }
}
