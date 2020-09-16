@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-1 text-right">
        <a href="{{ route('order.index') }}" class="btn btn-primary shadow"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
    </div>
    <div class="col-5 card bg-primary p-2 shadow">
        <span class="text-center text-light h4 m-0">Tambah Pesanan</span>
    </div>
    <div class="col-5 ml-3 card bg-primary p-2 shadow">
        <span class="text-center text-light h4 m-0">Data Pesanan</span>
    </div>
</div>

<div class="row">
    <div class="col-5 offset-1 p-0">
        <div class="card p-3 shadow">
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="">Nomor Meja</label>
                        <select name="meja" id="meja" class="form-control select" style="width: 100%;">
                            <option value="NULL">Pilih Meja</option>
                            @foreach($tables as $table)
                            <option value="{{ $table->id }}">Meja {{ $table->number }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <hr class="bg-dark m-0">
                </div>
                <div class="col-12">
                    <div class="row mt-3">
                        <div class="col-4">Makanan / Minuman</div>
                        <div class="col-3">Kuantitas</div>
                        <div class="col-5">Catatan</div>
                    </div>
                    <div class="row mt-3 order-wrapper">
                        <div class="col-4">
                            <div class="form-group">
                                <select name="nama" id="menu" class="form-control select" style="width: 100%;">
                                    <option value="NULL">Pilih</option>
                                    @foreach($menus as $menu)
                                    <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <input type="number" name="kuantitas" class="form-control form-control-sm" value="1" id="kuantitas" aria-describedby="helpId" placeholder="" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="form-group">
                                <input type="text" name="catatan" class="form-control form-control-sm" value="" id="catatan" aria-describedby="helpId" placeholder="" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <hr class="bg-dark m-0 mb-3">
                <button class="btn btn-info text-light" id="btn_tambah_order"><i class="fa fa-plus mr-2"></i>Tambah</button>
            </div>
        </div>
    </div>
    <div class="col-5 ml-3 p-0">
        <div class="card p-3 shadow">
            <div class="loading-overlay rounded d-none">
                <div class="loading text-light h5 text-center">
                    <div class="spinner-border text-light mb-2" role="status">
                        <span class="sr-only">Loading...</span>
                    </div><br>
                    Loading
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Kuantitas</th>
                        <th>Catatan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="order-table-data"></tbody>
            </table>
        </div>
    </div>
</div>
@endsection