<!DOCTYPE html>
<html>
<head>
	<title>Invoice</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
			text-align: center;
		}
		p{
			font-size: 10pt;
			margin: 0px;
		}
	</style>
	<center><h3>Starbhak Kantin</h3></center>
	<hr class="bg-dark">
	<p>Tanggal : {{ date('d-m-Y H:i:s') }}</p>
	<p>Kasir : {{ $user }}</p>
	<br>

	<table class='table table-bordered'>
		<thead>
			<tr>
                <th>Nama Pesanan</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Total</th>
			</tr>
		</thead>
		<tbody>
			@php $i = 0; @endphp
            @foreach($orders as $o)
			<tr>
				<td>{{$menu[$i]->name}}</td>
				<td>Rp. {{number_format($menu[$i]->price,0,',','.')}}</td>
				<td>{{$o->quantity}}</td>
				<td>Rp. {{number_format($o->total,0,',','.')}}</td>
			</tr>
			@php $i++; @endphp
			@endforeach
			<tr>
				<td colspan="2"></td>
				<td>Total</td>
				<td>Rp. {{number_format($total,0,',','.')}}</td>
			</tr>
			<tr>
				<td colspan="2"></td>
				<td>Uang</td>
				<td>Rp. {{number_format($cash,0,',','.')}}</td>
			</tr>
			<tr>
				<td colspan="2"></td>
				<td>Kembali</td>
				<td>Rp. {{number_format($change,0,',','.')}}</td>
			</tr>
		</tbody>
	</table>

</body>
</html>