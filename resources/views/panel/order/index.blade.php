@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-10 offset-1">
        <div class="card bg-primary p-3 shadow">
            <div class="row">
                <div class="col-6">
                    <p class="text-light h4 mt-1">Data Pesanan</p>
                </div>
                <div class="col-6 text-right">
                    <a href="{{ route('order.create') }}" class="btn btn-light"><i class="fa fa-plus mr-1" aria-hidden="true"></i>Tambah</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-10 offset-1">
        <div class="card p-3 pt-4 shadow">
            <table class="table data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Kuantitas</th>
                        <th>Total</th>
                        <th>Catatan</th>
                        <th>Meja</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1 @endphp
                    @foreach($orders as $order)
                    <tr>
                        <td scope="row">{{ $i }}</td>
                        <td>{{ $order->name }}</td>
                        <td>Rp. {{ number_format($order->price,0,',','.') }}</td>
                        <td>{{ $order->quantity }}</td>
                        <td>Rp. {{ number_format($order->total,0,',','.') }}</td>
                        <td>{{ $order->notes }}</td>
                        <td>Meja {{ $order->number }}</td>
                        <td class="text-center">
                            @if($order->status == "selesai")
                            <div class="bg-success rounded mr-3 w-100 text-light text-center">
                                selesai
                            </div>
                            @else
                            <div class="bg-info rounded mr-3 w-100 text-light text-center">
                                proses
                            </div>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('order.show', ['order' => $order->id]) }}" class="btn btn-primary btn-sm">Detil</a>
                        </td>
                    </tr>
                    @php $i++ @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection