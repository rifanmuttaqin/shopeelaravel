<!DOCTYPE html>
<html>
<head>
	<title>Label Pesanan</title>
<style type="text/css">

table {
  border-collapse: collapse;
}

table, th, td {
	border: 1px solid black;
}

</style>

</head>

<body>

	@foreach($data as $transaksi)

	<table style="width:100%">
		<tr>
			<td>{{ $transaksi->no_resi}}</td>
		</tr>
		<tr>
			<td>{{ $transaksi->username_pembeli }}</td>
		</tr>
		<tr>
			<td>{{ $transaksi->tgl_pesanan_dibuat }}</td>
		</tr>
		<!-- <tr>
			<td>
				<p> {{ $transaksi->produk }} </p>
			</td>
		</tr> -->
	</table>

	<hr>

	@endforeach

</body>

</html>