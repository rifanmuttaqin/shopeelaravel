<div style="width: 100%; padding-left: -10px;">
    <div class="table-responsive">
    <table id="table_result" class="table table-bordered data-table display nowrap" style="width:100%">
    <thead style="text-align:center;">
            <tr>
                <th style="width: 30%">Supplier</th>
                <th style="width: 30%">Tanggal Belanja</th>
                <th style="width: 10%">Total Belanja</th>
                <th style="width: 30%">Action</th>
            </tr>
    </thead>
            @php
                $total_amount = 0;
            @endphp
            @foreach ($transaksi as $key => $data)
            <tr>
                <td>{{ $data->supplier_name }}</td>
                <td>{{ $data->created_at }}</td>
                <td>{{ $data->total_amount }}</td>
                <td><a class='btn btn-info' href="{{ route('transaksi-po-detail', $data->id) }}"><i class='fas fa-eye'></i></a></td>
            </tr>
            
            @php
                $total_amount += $data->total_amount;
            @endphp

            @endforeach      
            <td colspan="2">Total</td>
            <td><strong>{{ $total_amount }}</strong></td>
    <tbody>
    </tbody>
    </table>
    </div>
</div>