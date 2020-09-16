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

.page-break {
    page-break-after: always;
}

</style>

</head>

<body>

	<?php $counter = 0; ?>

	@foreach($data as $transaksi)

		<table style="width:70%" class="fixed">
			<tr>
				<td style="text-align: center;">
					<img src="data:image/png;base64,{{DNS1D::getBarcodePNG($transaksi->no_resi, 'C128')}}" alt="barcode"/>
				</td>
			</tr>
			<tr>
				<td style="text-align: center;">{{ $transaksi->no_resi}}</td>
			</tr>
			<tr>
				<td>{{ $transaksi->username_pembeli }}</td>
			</tr>
			<tr>
				<td>{{ $transaksi->tgl_pesanan_dibuat }}</td>
			</tr>
			<tr>
				<td>
					<div style="text-align: justify;">
						<p> {{ TransaksiService::productExplode($transaksi->produk) }} </p>
					</div>
				</td>
			</tr>
		</table>

	<hr>
	
 	<?php $counter++; ?>

	<?php if( $counter % 3 == 0 ){ echo '<div class="page-break"></div>'; } ?>

	@endforeach

</body>

</html>