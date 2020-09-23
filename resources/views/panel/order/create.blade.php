@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-1 text-right">
        <a href="{{ route('order.index') }}" class="btn btn-primary shadow"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
    </div>
    <div class="col-5 card bg-primary p-2 shadow">
        <span class="text-center text-light h4 m-0">Tambah Pesanan</span>
    </div>
    <div class="col-5 ml-3 card bg-primary p-2 shadow">
        <span class="text-center text-light h4 m-0">Data Pesanan</span>
    </div>
</div>

<div class="row">
    <div class="col-5 offset-1 p-0">
        <div class="card p-3 shadow">
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="">Nomor Meja</label>
                        <select name="meja" id="meja" class="form-control select" style="width: 100%;"></select>
                    </div>
                </div>
                <div class="col-12">
                    <hr class="bg-dark m-0">
                </div>
                <div class="col-12">
                    <div class="row mt-3">
                        <div class="col-4">Makanan / Minuman</div>
                        <div class="col-3">Kuantitas</div>
                        <div class="col-5">Catatan</div>
                    </div>
                    <div class="row mt-3 order-wrapper">
                        <div class="col-4">
                            <div class="form-group">
                                <select name="nama" id="menu" class="form-control select" style="width: 100%;"></select>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <input type="number" name="kuantitas" class="form-control form-control-sm" value="1" id="kuantitas" aria-describedby="helpId" placeholder="" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="form-group">
                                <input type="text" name="catatan" class="form-control form-control-sm" value="" id="catatan" aria-describedby="helpId" placeholder="" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <hr class="bg-dark m-0 mb-3">
                <button class="btn btn-primary" id="btn_tambah_order"><i class="fa fa-plus mr-2"></i>Tambah</button>
                <button class="btn btn-info" id="btn_refresh"><i class="fas fa-sync"></i></button>
            </div>
        </div>
    </div>
    <div class="col-5 ml-3 p-0">
        <div class="card p-3 shadow">
            <div class="loading-overlay rounded d-none">
                <div class="loading text-light h5 text-center">
                    <div class="spinner-border text-light mb-2" role="status">
                        <span class="sr-only">Loading...</span>
                    </div><br>
                    Loading
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Kuantitas</th>
                        <th>Catatan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="order-table-data"></tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function order_data(){
        $('#meja, #menu').html('<option value="NULL">Loading...</option>');
        $.get("{{ route('order.get.data') }}", function(data, status){
            var table = '<option value="NULL">Pilih Meja</option>';
            var menu = '<option value="NULL">Pilih Menu</option>';
            data.tables.forEach(el => {
                table += '<option value="'+ el.id +'">Meja '+ el.number +'</option>';
            });
            data.menus.forEach(el => {
                menu += '<option value="'+ el.id +'">'+ el.name +'</option>';
            });
            $('.order-table-data').html('');
            $('#kuantitas').val('1');
            $('#catatan').val('');
            $('#meja').html(table);
            $('#menu').html(menu);
        });
    };

    $('#btn_refresh').click(function () { 
        order_data();
    });

    function ordered_table(meja){
        show_loading();
        $.get("{{ route('order.get.table') }}", {meja:meja}, function(data, status){
            $('.order-table-data').html('');
            data.forEach(d => {
                var openTag = '<tr>'
                var template = '<td scope="row">'+d.name+'</td><td>'+d.quantity+'</td><td>'+d.notes+'</td><td>'+d.status+'</td>';
                var closeTag = '</tr>'
                if (d.status == "proses") {
                    template += '<td>';
                    template += '<button class="btn btn-success btn-sm order-done" title="Selesai" value="'+ d.id +'"><i class="fa fa-check"></i></button>';
                    template += '<button class="btn btn-danger btn-sm order-cancel" title="Batal" value="'+ d.id +'"><i class="fa fa-times"></i></button>';
                    template += '</td>';
                }else{
                    template += '<td><button class="btn btn-danger btn-sm order-cancel" title="Batal" value="'+ d.id +'"><i class="fa fa-times"></i></button></td>';
                }
                $('.order-table-data').append(openTag + template + closeTag);
            });
            $('.order-done').click(function () { 
                show_loading();
                var id = $(this).val();
                $.post("{{ route('order.done') }}", {id: id}, function(data, status){
                    ordered_table($('#meja').val());
                });
                hide_loading();
            });
            $('.order-cancel').click(function () {
                show_loading();
                var id = $(this).val();
                $.post("{{ route('order.cancel') }}", {id: id}, function(data, status){
                    ordered_table($('#meja').val());
                });
                hide_loading();
            });
        });
        hide_loading();
    };

    $('#meja').change(function () { 
        var meja = $(this).val();
        ordered_table(meja);
    });

    $('#btn_tambah_order').click(function () { 
        show_loading();
        var meja = $('#meja').val();
        var menu = $('#menu').val();
        var kuantitas = $('#kuantitas').val();
        var catatan = $('#catatan').val();
        var send = {meja: meja, menu: menu, kuantitas: kuantitas, catatan: catatan}
        $.post("{{ route('order.store') }}", send, function(data, status){
            ordered_table($('#meja').val());
        });
        hide_loading();
    });
    
    order_data();
</script>
@endsection
<!--  -->