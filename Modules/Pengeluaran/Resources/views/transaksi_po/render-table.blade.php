<div style="width: 100%; padding-left: -10px;">
    <div class="table-responsive">
    <table id="table_result" class="table table-bordered data-table display nowrap" style="width:100%">
    <thead style="text-align:center;">
            <tr>
                <th style="width: 30%">Barang</th>
                <th style="width: 30%">Harga</th>
                <th style="width: 10%">Qty</th>
                <th style="width: 30%">Total</th>
                <th style="width: 30%">Action</th>
            </tr>
    </thead>
      
            @foreach ($produk as $key => $data_produk)
            <tr>
                <td>{{ $data_produk['nama_produk'] }}</td>
                <td>{{ $data_produk['total_price'] }}</td>
                <td>{{ $data_produk['qty'] }}</td>
                <td>{{ $data_produk['total'] }}</td> 
                <td><a class='btn btn-info' onclick="deleteArray({{ $key }})"><i class='fas fa-trash'></i></a></td>  
            </tr>
            @endforeach                 
    <tbody>
    </tbody>
    </table>
    </div>
</div>