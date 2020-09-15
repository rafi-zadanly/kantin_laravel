@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-4 text-right">
        <a href="{{ route('user.index') }}" class="btn btn-primary shadow"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
    </div>
    <div class="col-4 card bg-primary p-2 shadow">
        <span class="text-center text-light h4 m-0">Ubah Pengguna</span>
    </div>
</div>
<form action="{{ route('user.update', ['user' => $user->id]) }}" method="post">
@method('PUT')
@csrf
<div class="row">
    <div class="col-4 offset-4 card p-3 shadow">
        <div class="form-group">
            <label for="">Nama Lengkap</label>
            <input type="text" class="form-control" name="nama_lengkap" value="{{ old('nama_lengkap') == NULL ? $user->name : old('nama_lengkap') }}" id="" aria-describedby="helpId" placeholder="" autocomplete="off" autofocus>
            @error('nama_lengkap')<small id="helpId" class="form-text text-danger">{{ $message }}</small>@enderror
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="">Nama Pengguna</label>
                    <input type="text" class="form-control" name="nama_pengguna" value="{{ old('nama_pengguna') == NULL ? $user->username : old('nama_pengguna') }}" id="" aria-describedby="helpId" placeholder="" autocomplete="off">
                    @error('nama_pengguna')<small id="helpId" class="form-text text-danger">{{ $message }}</small>@enderror
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="">Kata Sandi</label>
                    <input type="text" class="form-control" name="kata_sandi" value="{{ old('kata_sandi') }}" id="" aria-describedby="helpId" placeholder="Ubah Kata sandi" autocomplete="off">
                    @error('kata_sandi')<small id="helpId" class="form-text text-danger">{{ $message }}</small>@enderror
                </div>
            </div>
        </div>
        @php $level = old('tingkat_pengguna') == NULL ? $user->level : old('tingkat_pengguna'); @endphp
        <div class="form-group">
            <label for="">Tingkat Pengguna</label>
            <select name="tingkat_pengguna" id="" class="form-control">
                <option value="NULL">Pilih tingkat</option>
                <option value="kasir" {{ $level == "kasir" ? 'selected' : '' }}>Kasir</option>
                <option value="waiter" {{ $level == "waiter" ? 'selected' : '' }}>Waiter</option>
                <option value="admin" {{ $level == "admin" ? 'selected' : '' }}>Admin</option>
                <option value="owner" {{ $level == "owner" ? 'selected' : '' }}>Owner</option>
            </select>
            @error('tingkat_pengguna')<small id="helpId" class="form-text text-danger">{{ $message }}</small>@enderror
        </div>
        <div class="text-right">
            <input type="hidden" name="hidden_nama_pengguna" value="{{ $user->username }}">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </div>
</form>
</div>
@endsection