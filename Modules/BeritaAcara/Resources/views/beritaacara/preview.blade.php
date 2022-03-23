<div style="width: 100%; padding-left: -10px;">
    <div class="table-responsive">
    <table id="table_result" class="table table-bordered data-table display nowrap" style="width:100%">
        <thead style="text-align:center;">
            <tr>
                <th style="width: 20%">Tanggal</th>
                <th style="width: 10%">Transaksi</th>
                <th style="width: 10%">Nominal Kerugian</th>
                <th style="width: 10%">Status Masalah</th>
                <th style="width: 50%">Detail Kejadian</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $beritaacara)   
            <tr>
                <td>{{ $beritaacara->tanggal }}</td>
                <td>{{ $transaksi->findById($beritaacara->transaksi_id)->no_resi }}</td>
                <td>{{ $beritaacara->nominal_kerugian }}</td>
                <td>{{ $beritaacara_service->statusMasalahMeaning($beritaacara->status_masalah) }}</td>
                <td>{{ $beritaacara_service->getReadmore($beritaacara) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>