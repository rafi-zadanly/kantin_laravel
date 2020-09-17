@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-10 offset-1">
        <div class="card bg-primary p-3 shadow">
            <div class="row">
                <div class="col-6">
                    <p class="text-light h4 mt-1">Data Transaksi</p>
                </div>
                <div class="col-6 text-right">
                    <a href="{{ route('transaction.create') }}" class="btn btn-light"><i class="fa fa-plus mr-1" aria-hidden="true"></i>Tambah</a>
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
                        <th>Tanggal</th>
                        <th>Meja</th>
                        <th>Total</th>
                        <th>Uang</th>
                        <th>Kembali</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1 @endphp
                    @foreach($transactions as $trs)
                    <tr>
                        <td scope="row">{{ $i }}</td>
                        <td>{{ $trs->date }}</td>
                        <td>Meja {{ $tables[$i-1]->number }}</td>
                        <td>{{ $trs->total != NULL ? 'Rp. '. number_format($trs->total,0,',','.') : '' }}</td>
                        <td>{{ $trs->cash != NULL ? 'Rp. '. number_format($trs->cash,0,',','.') : '' }}</td>
                        <td>{{ $trs->change != NULL || $trs->change == 0 ? 'Rp. '. number_format($trs->change,0,',','.') : '' }}</td>
                        <td class="text-center">
                            @if($trs->status == "paid")
                            <div class="bg-success rounded mr-3 w-100 text-light text-center">
                                Dibayar
                            </div>
                            @else
                            <div class="bg-info rounded mr-3 w-100 text-light text-center">
                                Belum
                            </div>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('transaction.show', ['transaction' => $trs->id]) }}" class="btn btn-primary btn-sm">Detil</a>
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