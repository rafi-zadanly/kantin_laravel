<?php

namespace App\Http\Controllers;

use App\Models\CanteenMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class CanteenMenuController extends Controller
{
    protected $defaultRedirect = "canteen-menu.index";

    public function index()
    {
        $data = [
            'page' => 'Menu Kantin',
            'menus' => CanteenMenu::all(),
        ];
        return view('panel.canteen-menu.index', $data);
    }

    public function create()
    {
        $data = [
            'page' => 'Menu Kantin',
        ];
        return view('panel.canteen-menu.create', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => ['required', 'min:3', 'max:50', 'unique:canteen_menus,name'],
            'harga' => ['required', 'numeric'],
            'tersedia' => ['required'],
        ], $this->message);

        if($validator->fails()){
            return $this->validate_fails($validator);
        }else{
            $data = new CanteenMenu();
            $data->name = $request->nama;
            $data->price = $request->harga;
            $data->status = $request->tersedia;
            if ($data->save()) {
                return $this->success_redirect("Berhasil menambahkan menu kantin.", $this->defaultRedirect);
            }else{
                return $this->error_redirect();
            }
        }
    }

    public function show(CanteenMenu $canteenMenu)
    {
        //
    }

    public function edit(CanteenMenu $canteenMenu)
    {
        $data = [
            'page' => 'Menu Kantin',
            'menu' => $canteenMenu,
        ];
        return view('panel.canteen-menu.edit', $data);
    }

    public function update(Request $request, CanteenMenu $canteenMenu)
    {
        $validate = [
            'harga' => ['required', 'numeric'],
            'tersedia' => ['required'],
        ];
        Str::lower($request->hidden_nama) != Str::lower($request->nama) ? 
        $validate['nama'] = ['required', 'min:3', 'max:50', 'unique:canteen_menus,name'] : '';

        $validator = Validator::make($request->all(), $validate, $this->message);
        
        if($validator->fails()){
            return $this->validate_fails($validator);
        }else{
            $update = [
                'name' => $request->nama,
                'price' => $request->harga,
                'status' => $request->tersedia,
            ];
            if ($canteenMenu->update($update)) {
                return $this->success_redirect("Berhasil mengubah menu $canteenMenu->name.", $this->defaultRedirect);
            }else{
                return $this->error_redirect();
            }
        }
    }

    public function destroy(CanteenMenu $canteenMenu)
    {
        if ($canteenMenu->delete()) {
            return $this->success_redirect("Berhasil menghapus menu $canteenMenu->name.", $this->defaultRedirect);
        }else{
            return $this->error_redirect();
        }
    }
}
