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

hr {
       display: block;
       position: relative;
       padding: 0;
       margin: 8px auto;
       height: 0;
       width: 100%;
       max-height: 0;
       font-size: 1px;
       line-height: 0;
       clear: both;
       border: none;
       border-top: 1px solid #aaaaaa;
       border-bottom: 1px solid #ffffff;
}

</style>

</head>

<body>

	<?php $counter = 0; ?>

	@foreach($data as $transaksi)

		<table style="width:50%" class="fixed">
			<tr>
				<td style="text-align: center;">
					<img src="data:image/png;base64,{{DNS1D::getBarcodePNG($transaksi->no_resi, 'C128')}}" alt="barcode"/>
				</td>
			</tr>
			<tr>
				<td style="text-align: center;">{{ $transaksi->no_resi}}</td>
			</tr>
			<tr>
				<td>
					<div style="text-align: center; font-size: 6px">
						<ul>Username Shopee : {{ $transaksi->username_pembeli }}</ul>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div style="text-align: center; font-size: 6px">
						<ul>Waktu memesan : {{ $transaksi->tgl_pesanan_dibuat }}</ul>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div style="text-align: justify; font-size: 6px">
						<ul> {!! TransaksiService::productExplode($transaksi->produk) !!} </ul>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div style="text-align: justify; font-size: 6px">
						<ul> Catatan : </ul>
					</div>
				</td>
			</tr>
		</table>
	<hr>
	
 	<?php $counter++; ?>

	<?php if( $counter % 5 == 0 ){ echo '<div class="page-break"></div>'; } ?>

	@endforeach

</body>

</html>