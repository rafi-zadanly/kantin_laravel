@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-6 offset-3">
        <div class="card bg-primary p-3 shadow">
            <div class="row">
                <div class="col-6">
                    <p class="text-light h4 mt-1">Data Meja</p>
                </div>
                <div class="col-6 text-right">
                    <a href="{{ route('table.create') }}" class="btn btn-light"><i class="fa fa-plus mr-1" aria-hidden="true"></i>Tambah</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 offset-3">
        <div class="card p-3 pt-4 shadow">
            <table class="table data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nomor Meja</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1 @endphp
                    @foreach($tables as $table)
                    <tr>
                        <td scope="row">{{ $i }}</td>
                        <td>Meja {{ $table->number }}</td>
                        <td class="text-center">
                            <a href="{{ route('table.edit', ['table' => $table->id]) }}" class="btn btn-primary btn-sm"><i class="fa fa-pencil-alt"></i></a>
                            <a href="#" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete_{{ $i }}"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <div class="modal fade" id="delete_{{ $i }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Anda yakin untuk menghapus Meja "{{$table->number }}"</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-footer">
                                    <form action="{{ route('table.destroy', ['table' => $table->id]) }}" method="post">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php $i++ @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection