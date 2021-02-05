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

ul {
	padding-left: 8px;
}

hr {
       display: block;
       color: red;
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

		<table style="width:100%" class="fixed">
			<tr>
				<td style="text-align: center;">
					<img src="data:image/png;base64,{{DNS1D::getBarcodePNG($transaksi->no_resi, 'C128')}}" alt="barcode"/>
				</td>
			</tr>
			<tr>
				<td style="text-align: center;">{{ $transaksi->no_resi}} / <p style="font-size: 6px"> {{ $transaksi->kota_pembeli }} - {{ $transaksi->provinsi_pembeli }} </p></td>
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
					<div style="text-align: justify; font-size: 6px;">
						<ul> {!! TransaksiService::productExplode($transaksi->produk) !!} </ul>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div style="text-align: justify; font-size: 8px">
						<ul> Catatan : {{ $transaksi->catatan_order }}</ul>
					</div>
				</td>
			</tr>
		</table>

		<hr>
			<div style="text-align: justify; font-size: 12px">
				<p style="width:100%"> {{ $setting->customer_note }}</p>
			</div>
	
 	<?php $counter++; ?>

	<?php if( $counter % 1 == 0 ){ echo '<div class="page-break"></div>'; } ?>

	@endforeach

</body>

</html>