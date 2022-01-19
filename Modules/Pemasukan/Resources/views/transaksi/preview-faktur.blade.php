<html>
    <head>
        <style type="text/css">
            .main-content {
                font-family: 'Monospace';
                font-size:10px;
                margin-top: 10px;
                margin-left: 10px;
            }
            p {
                text-align: center;
            }
            body {
                width: 100%;
                margin-bottom: auto;
                border: 1px solid black;
            }
            hr {
                display: block;
                margin-left: 5px;
                margin-right: 5px;
                border-style: inset;
                border-width: 1px;
            }
        </style>
    </head>
    <body>

    <div class="main-content">
    
    <table style="width: 100%">
        <tr>
            <th> Pusat Grosir & Ecer Makanan Ringan </th>
        </tr> 
        <tr>
            <th> Al Barr Snack </th>
        </tr>  
        <tr>
            <th> <small> snack.albarrgroup.com </small> </th>
        </tr>    
    </table>

    <hr>

    <table style="width: 100%; margin-top: 10px">
        <tr>
            <td style="width: 100px">Yth Kakak : </td>
            <td>{{ $main_transaksi->nama_customer }}</td>
        </tr>    
        <tr>
            <td style="width: 100px">No Invoice : </td>
            <td>{{ $main_transaksi->invoice_code }}</td>
        </tr>
    </table>

    <p> <small> {{ $main_transaksi->created_at != null ? date_format($main_transaksi->created_at,"d F Y H:i:s") : null }} </small> </p>

    <hr>

    <table style="width: 100%;">
   
        <tr>
            <th style="text-align: left">Barang</th>
            <th style="text-align: left">Jumlah</th>
            <th style="text-align: left">Harga</th>
        </tr>
    
        @foreach ($transkasi_detail as $data)
        <tr>
            <td>{{ $data->nama_produk}}</td>
            <td>{{ $data->qty_beli}}</td>
            <td>{{ $data->harga_produk}}</td>
            </tr>
        @endforeach
   
    </table>


    <table style="width: 100%; margin-top: 20px">
        <tr>
            <td> Diskon didapat </td>
            <td>{{ $main_transaksi->discount_amount != null ? $main_transaksi->discount_amount : 0 }}</td>
        </tr>
        <tr>
            <td> Total Belanja </td>
            <td><strong>{{ $main_transaksi->total_amount }}</strong></td>
        </tr>
    </table>
    
    <table style="width: 100%; margin-top: 10px;">
        <tr>
            <th> Terimakasih telah berbelanja </th>
        </tr> 
    </table>

    </div>
    </body>
</html>