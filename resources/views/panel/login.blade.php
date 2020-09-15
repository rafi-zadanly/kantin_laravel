<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Canteen App</title>
    
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
</head>

<body class="d-none login">
    @if(Session::has('alert'))
        @component('layouts.alert')
            @slot('class')
                {{ Session::get('type') }}
            @endslot
            {{ Session::get('alert') }}
        @endcomponent
    @endif
    <div class="login-overlay"></div>

    <div class="login-wrapper rounded p-3">
        <h3 class="text-center text-light">CANTEEN APP</h3>
        <hr class="bg-light">
        <form action="{{ route('auth.check') }}" method="post">
        @csrf
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="" class="text-light">Nama Pengguna</label>
                    <input type="text" name="nama_pengguna" id="" class="form-control" autocomplete="off" autofocus>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="" class="text-light">Kata Sandi</label>
                    <input type="password" name="kata_sandi" id="" class="form-control">
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-danger w-100">Masuk</button>
        </form>
    </div>
    <script src="{{ mix('js/app.js') }}"></script>

    <script type="text/javascript">
        $(function () {
            $('body').hide();
            $('body').removeClass('d-none');
            $('body').fadeIn(750);
        });
    </script>
</body>