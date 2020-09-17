@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-4 offset-4">
        <div class="alert shadow d-none" role="alert"></div>
    </div>
</div>

<div class="row">
    <div class="col-1 text-right">
        <a href="{{ route('transaction.index') }}" class="btn btn-primary shadow"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
    </div>
    <div class="col-7 card bg-primary p-2 shadow">
        <span class="text-center text-light h4 m-0">Transaksi</span>
    </div>
    <div class="col-3 ml-3 card bg-primary p-2 shadow">
        <span class="text-center text-light h4 m-0">Pembayaran</span>
    </div>
</div>

<div class="row">
    <div class="col-7 offset-1 p-0">
        <div class="card p-3 shadow">
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="">Nomor Meja</label>
                        <select name="meja" id="meja_transaksi" class="form-control select" style="width: 100%;">
                            <option value="NULL">Pilih Meja</option>
                            @foreach($tables as $table)
                            <option value="{{ $table->id }}">Meja {{ $table->number }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <div class="loading-overlay rounded d-none">
                        <div class="loading text-light h5 text-center">
                            <div class="spinner-border text-light mb-2" role="status">
                                <span class="sr-only">Loading...</span>
                            </div><br>
                            Loading
                        </div>
                    </div>
                    <hr class="bg-dark m-0 mb-3">
                    <p class="h5 text-dark mb-3">Rincian Pesanan</p>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th>Kuantitas</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody class="transaction-table-data"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-3 ml-3 p-0">
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
                <tr>
                    <th>Total</th>
                    <td>
                        <div class="input-group">
                            <div class="input-group-text p-0 pl-2 pr-2">Rp.</div>
                            <input type="text" class="form-control form-control-sm" name="" id="total-form" value="" readonly>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>Uang</th>
                    <td>
                        <div class="input-group">
                            <div class="input-group-text p-0 pl-2 pr-2">Rp.</div>
                            <input type="number" class="form-control form-control-sm" name="" id="cash-form" placeholder="">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>Kembali</th>
                    <td>
                        <div class="input-group">
                            <div class="input-group-text p-0 pl-2 pr-2">Rp.</div>
                            <input type="text" class="form-control form-control-sm" name="" id="change-form" readonly>
                        </div>
                    </td>
                </tr>
            </table>
            <button class="btn btn-primary" id="btn_bayar_transaksi">Bayar</button>
        </div>
    </div>
</div>
@endsection