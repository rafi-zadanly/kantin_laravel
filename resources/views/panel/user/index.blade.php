@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-10 offset-1">
        <div class="card bg-primary p-3 shadow">
            <div class="row">
                <div class="col-6">
                    <p class="text-light h4 mt-1">Data Pengguna</p>
                </div>
                <div class="col-6 text-right">
                    <a href="{{ route('user.create') }}" class="btn btn-light"><i class="fa fa-plus mr-1" aria-hidden="true"></i>Tambah</a>
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
                        <th>Nama Lengkap</th>
                        <th>Nama Pengguna</th>
                        <th>Kata Sandi</th>
                        <th>Tingkat</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1 @endphp
                    @foreach($users as $user)
                    <tr>
                        <td scope="row">{{ $i }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->username }}</td>
                        <td>Tidak Ditampilkan</td>
                        <td class="text-capitalize">{{ $user->level }}</td>
                        <td class="text-center">
                            <a href="{{ route('user.edit', ['user' => $user->id]) }}" class="btn btn-primary btn-sm"><i class="fa fa-pencil-alt"></i></a>
                            <a href="#" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete_{{ $i }}"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <div class="modal fade" id="delete_{{ $i }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Anda yakin untuk menghapus "{{$user->name }}"</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-footer">
                                    <form action="{{ route('user.destroy', ['user' => $user->id]) }}" method="post">
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