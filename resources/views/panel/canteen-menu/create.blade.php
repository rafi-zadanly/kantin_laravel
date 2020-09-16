@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-4 text-right">
        <a href="{{ route('canteen-menu.index') }}" class="btn btn-primary shadow"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
    </div>
    <div class="col-4 card bg-primary p-2 shadow">
        <span class="text-center text-light h4 m-0">Tambah Menu Kantin</span>
    </div>
</div>
<form action="{{ route('canteen-menu.store') }}" method="post">
@csrf
<div class="row">
    <div class="col-4 offset-4 card p-3 shadow">
        <div class="form-group">
            <label for="">Nama</label>
            <input type="text" class="form-control" name="nama" value="{{ old('nama') }}" id="" aria-describedby="helpId" placeholder="" autocomplete="off" autofocus>
            @error('nama')<small id="helpId" class="form-text text-danger">{{ $message }}</small>@enderror
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="">Harga</label>
                    <input type="text" class="form-control" name="harga" value="{{ old('harga') }}" id="" aria-describedby="helpId" placeholder="" autocomplete="off">
                    @error('harga')<small id="helpId" class="form-text text-danger">{{ $message }}</small>@enderror
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="">Tersedia</label>
                    <div class="form-check pt-2 pl-0">
                        <input type="radio" name="tersedia" id="unavailable" value="unavailable" {{ old('tersedia') == "unavailable" ? 'checked' : '' }}>
                        <label class="form-check-label" for="unavailable">Tidak</label>

                        <input type="radio" name="tersedia" id="available" value="available" class="ml-2" {{ old('tersedia') == "available" ? 'checked' : '' }}>
                        <label class="form-check-label" for="available">Iya</label>
                    </div>
                    @error('tersedia')<small id="helpId" class="form-text text-danger">{{ $message }}</small>@enderror
                </div>
            </div>
        </div>
        <div class="text-right">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </div>
</form>
</div>
@endsection