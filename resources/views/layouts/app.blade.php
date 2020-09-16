@php 
$active = "active"; 
$level = Session::get('level');
@endphp
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Canteen App</title>
    
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jq-3.3.1/jszip-2.5.0/dt-1.10.21/b-1.6.3/b-html5-1.6.3/r-2.2.5/datatables.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
</head>

<body class="d-none">
    @if(Session::has('alert'))
        @component('layouts.alert')
            @slot('class')
                {{ Session::get('type') }}
            @endslot
            {{ Session::get('alert') }}
        @endcomponent
    @endif
    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div id="dismiss" class="mt-2 rounded">
                <i class="fas fa-arrow-left"></i>
            </div>

            <div class="sidebar-header">
                <h3>Canteen App</h3>
            </div>

            <ul class="list-unstyled components">
                <li class="{{ $page == 'Dasbor' ? $active : '' }}">
                    <a href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt sidebar-fa"></i>Dasbor</a>
                </li>
                @if(in_array($level, ['admin', 'kasir']))
                <li>
                    <a href="#">
                        <i class="fas fa-money-bill-alt sidebar-fa"></i>Transaksi
                    </a>
                </li>
                @endif
                @if(in_array($level, ['admin', 'waiter']))
                <li class="{{ $page == 'Pesanan' ? $active : '' }}">
                    <a href="{{ route('order.index') }}">
                        <i class="fa fa-shopping-cart sidebar-fa"></i>Pesanan
                    </a>
                </li>
                @endif
                @if(in_array($level, ['admin']))
                <li class="{{ $page == 'Menu Kantin' ? $active : '' }}">
                    <a href="{{ route('canteen-menu.index') }}">
                        <i class="fas fa-hamburger sidebar-fa"></i>Menu Kantin
                    </a>
                </li>
                <li class="{{ $page == 'Meja' ? $active : '' }}">
                    <a href="{{ route('table.index') }}">
                        <i class="fas fa-chair sidebar-fa"></i>Meja
                    </a>
                </li>
                <li class="{{ $page == 'Pengguna' ? $active : '' }}">
                    <a href="{{ route('user.index') }}">
                        <i class="fa fa-user sidebar-fa"></i>Pengguna
                    </a>
                </li>
                @endif
                @if(in_array($level, ['admin', 'owner']))
                <li>
                    <a href="#">
                        <i class="fa fa-file sidebar-fa"></i>Laporan
                    </a>
                </li>
                @endif
            </ul>
        </nav>

        <!-- Page Content  -->
        <div id="content">

            <nav class="navbar navbar-expand-lg navbar-light bg-light shadow rounded">
                <div class="container-fluid">

                    <button type="button" id="sidebarCollapse" class="btn btn-info text-light">
                        <i class="fas fa-align-left"></i>
                    </button>
                    <span class="h4 mt-auto ml-3">{{ $page }}</span>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto">
                            <li class="nav-item">
                                <form action="{{ route('auth.destroy') }}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <span class="mt-auto">{{ Session::get('name') }}</span>
                                    <button type="submit" class="btn btn-outline-danger ml-3">
                                        <i class="fa fa-power-off" aria-hidden="true"></i>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </div>

    <div class="overlay"></div>

    <script src="{{ mix('js/app.js') }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jq-3.3.1/jszip-2.5.0/dt-1.10.21/b-1.6.3/b-html5-1.6.3/r-2.2.5/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <!-- jQuery Custom Scroller CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $("#sidebar").mCustomScrollbar({
                theme: "minimal"
            });

            $('#dismiss, .overlay').on('click', function () {
                $('#sidebar').removeClass('active');
                $('.overlay').removeClass('active');
            });

            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').addClass('active');
                $('.overlay').addClass('active');
                $('.collapse.in').toggleClass('in');
                $('a[aria-expanded=true]').attr('aria-expanded', 'false');
            });

            $('.btn-order-check').click(function () { 
                $(this).parents()[1].remove(); 
                // Menghapus Baris yang sudah di klik
                $(this).attr('order-id');
                // Mengambil attribut order id
            });

            $('.data-table').DataTable();
            $('.select').select2();
        });
        $(function () {
            $('body').hide();
            $('body').removeClass('d-none');
            $('body').fadeIn(750);
        });
        function show_loading(){
            $('.loading-overlay').hide();
            $('.loading-overlay').removeClass('d-none');
            $('.loading-overlay').fadeIn('slow');
        }
        function hide_loading(){
            $('.loading-overlay').fadeOut('slow', function(){
                $('.loading-overlay').hide();
                $('.loading-overlay').addClass('d-none');
            });
        }

        function request_ajax(id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "post",
                url: "{{ route('order.done') }}",
                data: {id: id},
                dataType: "json",
                success: function (response) {
                    ordered_table($('#meja').val());
                }
            });
            hide_loading();
        }
        function ordered_table(meja){
            $.ajax({
                type: "get",
                url: "{{ route('order.get.table') }}",
                data: "meja="+meja,
                dataType: "json",
                success: function (data) {
                    $('.order-table-data').html('');
                    data.forEach(d => {
                        var openTag = '<tr>'
                        var template = '<td scope="row">'+d.name+'</td><td>'+d.quantity+'</td><td>'+d.notes+'</td><td>'+d.status+'</td>';
                        var closeTag = '</tr>'
                        if (d.status == "proses") {
                            template += '<td><button class="btn btn-success btn-sm order-done" value="'+ d.id +'"><i class="fa fa-check"></i></button></td>';
                        }
                        $('.order-table-data').append(openTag + template + closeTag);
                    });
                    $('.order-done').click(function () { 
                        show_loading();
                        var id = $(this).val();
                        request_ajax(id);
                    });
                }
            });
            hide_loading();
        };

        $('#meja').change(function () { 
            show_loading();
            var meja = $(this).val();
            ordered_table(meja);
        });

        $('#btn_tambah_order').click(function () { 
            show_loading();
            var meja = $('#meja').val();
            var menu = $('#menu').val();
            var kuantitas = $('#kuantitas').val();
            var catatan = $('#catatan').val();
            var data = {meja: meja, menu: menu, kuantitas: kuantitas, catatan: catatan}
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "post",
                url: "{{ route('order.store') }}",
                data: data,
                dataType: "json",
                success: function (response) {
                    ordered_table(response.meja);
                }
            });
            hide_loading();
        });
    </script>
</body>

</html>