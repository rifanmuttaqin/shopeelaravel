@extends('master')
 
@section('title', '{{ $title }}')

@section('alert')

@if(Session::has('alert_success'))
  @component('components.alert')
        @slot('class')
            success
        @endslot
        @slot('title')
            Terimakasih
        @endslot
        @slot('message')
            {{ session('alert_success') }}
        @endslot
  @endcomponent
@elseif(Session::has('alert_error'))
  @component('components.alert')
        @slot('class')
            error
        @endslot
        @slot('title')
            Cek Kembali
        @endslot
        @slot('message')
            {{ session('alert_error') }}
        @endslot
  @endcomponent 
@endif

@endsection

@section('content')

<div class="row">
<div class="col-lg-12 col-md-12 col-12 col-sm-12">
    <div class="card">
    <div class="card-header">
    	<h4>{{ $title }} Periode</h4>
    </div>
    <div class="card-body">

    <div class="form-group">
        <label><small>Periode Tahun</small></label>
        <select style="width: 100%" class="form-control" name="tahun" id="tahun">
        </select>
    </div>

    <div style="padding-bottom: 20px">
      	<button id="previewGrafik" type="button" class="btn btn-info"> <i class="fas fa-chart-line"></i> Tampil Grafik </button>
    </div>

    <div id="chart-result">
      	<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
    </div>
        
    </div>
    </div>
</div>
</div>


@endsection

@push('scripts')

<script type="text/javascript">

$(function () {

  $('#chart-result').hide();

  $('#tahun').each(function() {

    var year = (new Date()).getFullYear();
    var current = year;
    year -= 8;
    for (var i = 0; i < 9; i++) {
    if ((year+i) == current)
      	$(this).append('<option selected value="' + (year + i) + '">' + (year + i) + '</option>');
    else
      	$(this).append('<option value="' + (year + i) + '">' + (year + i) + '</option>');
    }

  })

   $('#previewGrafik').click(function(){
      
      var tahun = $('#tahun').val();
      var tipe_laporan = $('#tipe_laporan').val();

      $.ajax({  
        type:'POST',
        url: '{{route("report-transaksi-grafik-show")}}',
        data:{
            tahun:tahun,
            "_token": "{{ csrf_token() }}",
            },
        success:function(data) 
        {
            if(data)
            {       
              $('#chart-result').show(); 

					$('#container').highcharts({
					chart: {
						type: 'line'
					},
					title: {
						text: 'Laporan Transaksi Periode Tahunan'
					},
					subtitle: {
						text: 'priode : Sepanjang Tahun ' + tahun
					},
					xAxis: {
						categories: data.sumbu_x 
					},
					yAxis: {
						min: 0,
					title: {
						text: 'Jumlah'
					}
					},
					tooltip: {
						headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
						pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
						'<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
						footerFormat: '</table>',
						shared: true,
						useHTML: true
					},
					plotOptions: {
						column: {
						pointPadding: 0.2,
						borderWidth: 0,
						}
					},
					series: [
					{
						name : 'Jumlah Paket Dikirim',
						data: data.jumlah_paket
					},
					{
						name : 'Jumlah Customer Baru',
						data: data.jumlah_customer_baru
					}
					]
					});    
            }
            else
            {
              	$('#result_cart').hide();
            }
        }
      });
  })


});

</script>

@endpush