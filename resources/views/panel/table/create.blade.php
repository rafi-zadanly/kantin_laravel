@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-4 text-right">
        <a href="{{ route('table.index') }}" class="btn btn-primary shadow"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
    </div>
    <div class="col-4 card bg-primary p-2 shadow">
        <span class="text-center text-light h4 m-0">Tambah Meja</span>
    </div>
</div>
<form action="{{ route('table.store') }}" method="post">
@csrf
<div class="row">
    <div class="col-4 offset-4 card p-3 shadow">
        <div class="form-group">
            <label for="">Nomor Meja</label>
            <input type="text" class="form-control" name="nomor_meja" value="{{ old('nomor_meja') }}" id="" aria-describedby="helpId" placeholder="" autocomplete="off">
            @error('nomor_meja')<small id="helpId" class="form-text text-danger">{{ $message }}</small>@enderror
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>
</div>
@endsection