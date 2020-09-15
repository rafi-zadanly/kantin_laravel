@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-1"></div>
    <div class="col-2">
        <div class="card card-dashboard shadow-sm">
            <div class="card-body text-right">
                <h4 class="card-title">{{ $user->count() }}</h4>
                <p class="card-text h5 text-dark">Pengguna</p>
            </div>
        </div>
    </div>
    <div class="col-2">
        <div class="card card-dashboard shadow-sm">
            <div class="card-body text-right">
                <h4 class="card-title">23</h4>
                <p class="card-text h5 text-dark">Menu</p>
            </div>
        </div>
    </div>
    <div class="col-2">
        <div class="card card-dashboard shadow-sm">
            <div class="card-body text-right">
                <h4 class="card-title">{{ $table->count() }}</h4>
                <p class="card-text h5 text-dark">Meja</p>
            </div>
        </div>
    </div>
    <div class="col-2">
        <div class="card card-dashboard shadow-sm">
            <div class="card-body text-right">
                <h4 class="card-title">5</h4>
                <p class="card-text h5 text-dark">Pesanan</p>
            </div>
        </div>
    </div>
    <div class="col-2">
        <div class="card card-dashboard shadow-sm">
            <div class="card-body text-right">
                <h4 class="card-title">15</h4>
                <p class="card-text h5 text-dark">Transaksi</p>
            </div>
        </div>
    </div>
</div>
<div class="row pl-3 pr-3 mt-5">
    <div class="col-10 offset-1 card card-dashboard shadow p-3">
        <p class="h4 text-dark">Pesanan Saat Ini</p>
        <table class="table mt-3 table-responsive-sm">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Meja</th>
                    <th>Nama</th>
                    <th>Kuantitas</th>
                    <th>Catatan</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td scope="row">1</td>
                    <td>1</td>
                    <td>Nasi Goreng</td>
                    <td>2</td>
                    <td>1 Pedas, 1 Biasa</td>
                    <td class="text-center">
                        <button class="btn p-0 btn-order-check" order-id="1">
                            <i class="fa fa-check-square h4 text-primary" aria-hidden="true"></i>
                        </button>
                    </td>
                </tr>
                <tr>
                    <td scope="row">2</td>
                    <td>1</td>
                    <td>Es Teh Manis</td>
                    <td>3</td>
                    <td>1 Es nya dibanyakin</td>
                    <td class="text-center">
                        <button class="btn p-0 btn-order-check" order-id="2">
                            <i class="fa fa-check-square h4 text-primary" aria-hidden="true"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection