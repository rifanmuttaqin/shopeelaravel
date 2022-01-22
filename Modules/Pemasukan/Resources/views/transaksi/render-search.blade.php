<div style="width: 100%; padding-left: -10px;">
    <div class="table-responsive">
    <table id="table_result" class="table table-bordered data-table display nowrap" style="width:100%">
    <thead style="text-align:center;">
            <tr>
                <th style="width: 20%">Invoice</th>
                <th style="width: 30%">Customer</th>
                <th style="width: 20%">Tanggal Belanja</th>
                <th style="width: 10%">Total Belanja</th>
                <th style="width: 20%">Action</th>
            </tr>
    </thead>
            @php
                $total_amount = 0;
            @endphp
            @foreach ($transaksi as $key => $data)

            @php
                        
            if($data->status_transaksi == $status_belum_lunas)
            {
                $button = "<button class='btn btn-info float-right' data-value='$data->id' onclick=changeStatus('$data->id')><i class='fas fa-money-check-alt'></i></button>";
            }
            else
            {
                $button = null;
            }

            @endphp

            <tr>
                <td>{{ $data->invoice_code }}</td>
                <td>{{ $data->nama_customer }}</td>
                <td>{{ $data->created_at }}</td>
                <td>{{ $data->total_amount }}</td>
                <td> 
                    {!! $button !!}                   
                    <a class='btn btn-info float-left' href="{{ route('transaksi-offline-detail', $data->id) }}"><i class='fas fa-eye'></i></a>
                </td>
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