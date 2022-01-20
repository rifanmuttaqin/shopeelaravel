<div style="width: 100%; padding-left: -10px;">
    <div class="table-responsive">
    <table id="table_result" class="table table-bordered data-table display nowrap" style="width:100%">
        <thead style="text-align:center;">
                <tr>
                    <th style="width: 30%">Pendapatan</th>
                    <th style="width: 30%">Total</th>
                </tr>
        </thead>
        <tbody>
            <tr>
                <td>Transaksi Shopee</td>
                <td style="text-align: right">Rp {{ number_format($income_shopee,0,",",".") }}</td>
            </tr>
            <tr>
                <td>Transaksi Non Shopee</td>
                <td style="text-align: right">Rp {{ number_format($income_transaksi_non_shopee,0,",",".") }}</td>
            </tr>
            <tr>
                <td><strong>Total Pendapatan</strong></td>
                <td style="text-align: right"><strong>Rp {{ number_format(($income_shopee + $income_transaksi_non_shopee),0,",",".") }}</strong></td>
            </tr>
        </tbody>
        <thead style="text-align:center;">
            <tr>
                <th style="width: 30%">Beban Usaha</th>
                <th style="width: 30%">Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Bahan Baku / PO Produk</td>
                <td style="text-align: right">RP {{ number_format(($outcome_transaksi_po),0,",",".") }}</td>
            </tr>
            <tr>
                <td>Iklan</td>
                <td style="text-align: right">RP {{ number_format(($outcome_iklan),0,",",".") }}</td>
            </tr>
            <tr>
                <td><strong>Total Beban Usaha</strong></td>
                <td style="text-align: right"><strong> Rp {{ number_format(($outcome_transaksi_po + $outcome_iklan),0,",",".") }}</strong></td>
            </tr>
        </tbody>
        <thead style="text-align:center;">
            <tr>
                <th style="text-align: left">LABA / RUGI</th>
                <th style="text-align: right">Rp {{ number_format((($income_shopee + $income_transaksi_non_shopee)-($outcome_transaksi_po + $outcome_iklan)) ,0,",",".") }}</th>
            </tr>
        </thead>
    </table>
    </div>
</div>