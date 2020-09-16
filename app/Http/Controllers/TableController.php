<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class TableController extends Controller
{
    protected $defaultRedirect = "table.index";

    public function index()
    {
        $data = [
            'page' => 'Meja',
            'tables' => Table::all(),
        ];
        return view('panel.table.index', $data);
    }

    public function create()
    {
        $data = [
            'page' => 'Meja',
        ];
        return view('panel.table.create', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nomor_meja' => ['required', 'numeric', 'unique:tables,number'],
        ], $this->message);

        if($validator->fails()){
            return $this->validate_fails($validator);
        }else{
            $data = new Table();
            $data->number = $request->nomor_meja;
            if ($data->save()) {
                return $this->success_redirect("Berhasil menambahkan meja.", $this->defaultRedirect);
            }else{
                return $this->error_redirect();
            }
        }
    }

    public function show(Table $table)
    {
        //
    }

    public function edit(Table $table)
    {
        $data = [
            'page' => 'Meja',
            'table' => $table,
        ];
        return view('panel.table.edit', $data);
    }

    public function update(Request $request, Table $table)
    {
        $validate = [];
        Str::lower($request->hidden_nomor_meja) != Str::lower($request->nomor_meja) ? $validate['nomor_meja'] = ['required', 'numeric', 'unique:tables,number'] : '';
        $validator = Validator::make($request->all(), $validate, $this->message);

        if($validator->fails()){
            return $this->validate_fails($validator);
        }else{
            if ($table->update(['number' => $request->nomor_meja])) {
                return $this->success_redirect("Berhasil mengubah meja nomor $table->number.", $this->defaultRedirect);
            }else{
                return $this->error_redirect();
            }
        }
    }

    public function destroy(Table $table)
    {
        if ($table->delete()) {
            return $this->success_redirect("Berhasil menghapus meja nomor $table->number.", $this->defaultRedirect);
        }else{
            return $this->error_redirect();
        }
    }
}
