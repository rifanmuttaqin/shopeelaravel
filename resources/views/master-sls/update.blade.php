@extends('master')

@section('title', 'Update Master SLS')

@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>Terdapat Kesalahan Pada Pengisian</li> {{$error}}
            @endforeach
        </ul>
    </div>
@endif

<div class="row">
<div class="col-lg-12 col-md-12 col-12 col-sm-12">
    <div class="card">
    <div class="card-header">
        <h4>{{ $title }}</h4>
    </div>
    <div class="card-body">

    <form class="user" method="post" action="{{ route('master-sls-update') }}">

		@csrf

		<div class="form-group">
        <label><small>ID SLS</small></label>
			<input type="text" class="form-control" value="{{$data->id_sls}}" name="id_sls">
            <input type="hidden" class="form-control" value="{{$data->id}}" name="id">
			@if ($errors->has('id_sls'))
			    <small><p style="color: red"><span>&#42;</span> {{ $errors->first('id_sls') }}</p></small>
			@endif
        </div>
        
        <div class="form-group row">
            <div class="col-sm-4 mb-3 mb-sm-0">
            <label><small>ID SLS Non</small></label>
            <input type="text" class="form-control" value="{{ $desa_detail->id_sls_non }}" name="id_sls_non" id="id_sls_non">
            </div>
            <div class="col-sm-4 ">
            <label><small>ID SLS Non Satu Digit</small></label>
            <input type="text" class="form-control" value="{{$desa_detail->id_sls_non_satu_digit}}" name="id_sls_non_satu_digit" id="id_sls_non_satu_digit">
            </div>
            <div class="col-sm-4">
            <label><small>105. Nama SLS/Non SLS</small></label>
            <input type="text" class="form-control" value="{{$desa_detail->nama_sls_non}}" name="nama_sls_non" id="nama_sls_non">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
            <label><small>FSUB</small></label>
            <input type="text" class="form-control" value="{{$desa_detail->fsub}}" name="fsub" id="fsub">
            </div>
            <div class="col-sm-6">
            <label><small>Nama Ketua SLS</small></label>
            <input type="text" class="form-control" value="{{$data->nama_ketua_sls}}" name="nama_ketua_sls" id="nama_ketua_sls">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
            <label><small>J MSLS 30</small></label>
            <input type="text" class="form-control" value="{{$data->j_msls_30}}" name="j_msls_30" id="j_msls_30">
            </div>
            <div class="col-sm-6">
            <label><small>Max</small></label>
            <input type="text" class="form-control" value="{{$data->max}}" name="max" id="max">
            </div>
        </div>

        <div class="form-group">
            <label><small>Belum</small></label>
			<input type="text" class="form-control" value="{{$data->belum}}" id="belum" name="belum">
			@if ($errors->has('belum'))
			    <small><p style="color: red"><span>&#42;</span> {{ $errors->first('belum') }}</p></small>
			@endif
        </div>

        <div class="form-group row">
            <div class="col-sm-3 mb-3 mb-sm-0">
            <label><small>Konfirmasi Bulan Lahir</small></label>
            <input type="text" class="form-control" value="{{$data->konfirmasi_bulan_lahir}}" name="konfirmasi_bulan_lahir" id="konfirmasi_bulan_lahir">
            </div>
            <div class="col-sm-3">
            <label><small>Konfirmasi Tanggal Lahir</small></label>
            <input type="text" class="form-control" value="{{$data->konfirmasi_tanggal_lahir}}" name="konfirmasi_tanggal_lahir" id="konfirmasi_tanggal_lahir">
            </div>
            <div class="col-sm-3">
            <label><small>Konfirmasi Tahun Lahir</small></label>
            <input type="text" class="form-control" value="{{$data->konfirmasi_tahun_lahir}}" name="konfirmasi_tahun_lahir" id="konfirmasi_tahun_lahir">
            </div>
            <div class="col-sm-3">
            <label><small>Konfirmasi Jenis Kelamin</small></label>
            <input type="text" class="form-control" value="{{$data->konfirmasi_jenis_kelamin}}" name="konfirmasi_jenis_kelamin" id="konfirmasi_jenis_kelamin">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-4 mb-3 mb-sm-0">
            <label><small>Pindah</small></label>
            <input type="text" class="form-control" value="{{$data->pindah}}" name="pindah" id="pindah">
            </div>
            <div class="col-sm-4">
            <label><small>Sudah</small></label>
            <input type="text" class="form-control" name="sudah" value="{{$data->sudah}}" id="sudah">
            </div>
            <div class="col-sm-4">
            <label><small>Ulang</small></label>
            <input type="text" class="form-control"  value="{{$data->ulang}}" name="ulang" id="ulang">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-4 mb-3 mb-sm-0">
            <label><small>Grand Total</small></label>
            <input type="text" disabled="true" class="form-control" value="{{ $data->belum + $data->konfirmasi_bulan_lahir + $data->konfirmasi_tanggal_lahir + $data->konfirmasi_tahun_lahir + $data->konfirmasi_jenis_kelamin + $data->pindah + $data->sudah + $data->ulang }}" name="grand_total" id="grand_total">
            </div>
            <div class="col-sm-4">
            <label><small>TBK SLS</small></label>
            <input type="text" disabled="true" class="form-control" value="{{ $data->max / 80 }}" name="tbk_sls" id="tbk_sls">
            </div>
            <div class="col-sm-4">
            <label><small>Target C1</small></label>
            <input type="text" disabled="true" class="form-control" value="{{ $data->max - $data->belum }}" name="target_c1" id="target_c1">
            </div>
        </div>


		<div class="form-group">
        <label><small>101. Provinsi</small></label>
		<select style="width: 100%"  class="form-control select2-class" name="provinsi_id" id="provinsi_id">
		</select>
		</div>

		<div class="form-group">
        <label><small>102. Kabupaten/Kota</small></label>
		<select style="width: 100%" class="form-control select2-class" name="kabupaten_id" id="kabupaten_id">
		</select>
		</div>

		<div class="form-group">
        <label><small>103. Kecamatan</small></label>
		<select style="width: 100%" class="form-control select2-class" name="kecamatan_id" id="kecamatan_id">
		</select>
		</div>

		<div class="form-group">
        <label><small>104. Desa</small></label>
		<select style="width: 100%" class="form-control select2-class" name="desa_id" id="desa_id">
		</select>
		</div>

		<div class="form-group">
			<button type="submit" class="btn btn-info"> UPDATE </button>
		</div>

        <!-- Hidden Form Input  -->
        <input type="hidden" class="form-control" value="{{$data->provinsi->nama_provinsi}}" id="nama_provinsi">
        <input type="hidden" class="form-control" value="{{$data->provinsi->id}}" id="id_provinsi">

        <input type="hidden" class="form-control" value="{{$data->kabupaten->id}}" id="id_kabupaten">
        <input type="hidden" class="form-control" value="{{$data->kabupaten->nama_kabupaten}}" id="nama_kabupaten">
        
        <input type="hidden" class="form-control" value="{{$data->kecamatan->nama_kecamatan}}" id="nama_kecamatan">
        <input type="hidden" class="form-control" value="{{$data->kecamatan->id}}" id="id_kecamatan">

        <input type="hidden" class="form-control" value="{{$data->desa->nama_desa}}" id="nama_desa">
        <input type="hidden" class="form-control" value="{{$data->desa->id}}" id="id_desa">

	</form>
        
    </div>
    </div>
</div>
</div>
	
@endsection

@push('scripts')

<script type="text/javascript">

function getTbkValue()
{
    var tbk_sls = Number($('#max').val()) /80 || 0;
    return tbk_sls;
}

function getC1Value()
{
    var max = Number($('#max').val()) || 0;
    var belum = Number($('#belum').val()) || 0;

    return max-belum || 0;
}

function getGranTotal()
{
    var belum = Number($('#belum').val()) || 0;
    var konfirmasi_bulan_lahir = Number($('#konfirmasi_bulan_lahir').val()) || 0;
    var konfirmasi_tanggal_lahir = Number($('#konfirmasi_tanggal_lahir').val()) || 0;
    var konfirmasi_tahun_lahir = Number($('#konfirmasi_tahun_lahir').val()) || 0;
    var konfirmasi_jenis_kelamin = Number($('#konfirmasi_jenis_kelamin').val()) || 0;
    var pindah = Number($('#pindah').val()) || 0;
    var sudah = Number($('#sudah').val()) || 0;
    var ulang = Number($('#ulang').val()) || 0;

    var grand_total = 
    belum + konfirmasi_bulan_lahir + konfirmasi_tanggal_lahir + 
    konfirmasi_tahun_lahir + konfirmasi_jenis_kelamin + pindah + sudah + ulang; 

    return Number(grand_total);
}

var provinsi_nama   = $('#nama_provinsi').val();
var provinsi_id     = $('#id_provinsi').val();

var kabupaten_nama  = $('#nama_kabupaten').val(); 
var kabupaten_id    = $('#id_kabupaten').val();

var kecamatan_nama  = $('#nama_kecamatan').val();
var kecamatan_id    = $('#id_kecamatan').val();

var desa_nama   = $('#nama_desa').val();
var desa_id     = $('#id_desa').val();

$( document ).ready(function() {

$("#belum").keyup(function(){
    $('#grand_total').val(getGranTotal());
    $('#target_c1').val(getC1Value());
});

$("#max").keyup(function(){
    $('#tbk_sls').val(getTbkValue());
    $('#target_c1').val(getC1Value());
});


$("#konfirmasi_bulan_lahir").keyup(function(){
    $('#grand_total').val(getGranTotal());
});

$("#konfirmasi_tanggal_lahir").keyup(function(){
    $('#grand_total').val(getGranTotal());
});

$("#konfirmasi_tahun_lahir").keyup(function(){
    $('#grand_total').val(getGranTotal());
});

$("#konfirmasi_jenis_kelamin").keyup(function(){
    $('#grand_total').val(getGranTotal());
});

$("#pindah").keyup(function(){
    $('#grand_total').val(getGranTotal());
});

$("#sudah").keyup(function(){
    $('#grand_total').val(getGranTotal());
});

$("#ulang").keyup(function(){
    $('#grand_total').val(getGranTotal());
});

//Append Data To Select2 Option
var o = new Option(provinsi_nama, provinsi_id, false, false);
$(o).html(provinsi_nama);
$("#provinsi_id").append(o);
$('#provinsi_id').val(provinsi_id).trigger('change');

var o = new Option(kabupaten_nama, kabupaten_id);
$(o).html(kabupaten_nama);
$("#kabupaten_id").append(o);
$('#kabupaten_id').val(kabupaten_id).trigger('change');

var o = new Option(kecamatan_nama, kecamatan_id);
$(o).html(kecamatan_nama);
$("#kecamatan_id").append(o);
$('#kecamatan_id').val(kecamatan_id).trigger('change');

var o = new Option(desa_nama, desa_id);
$(o).html(desa_nama);
$("#desa_id").append(o);
$('#desa_id').val(desa_id).trigger('change');

$('#provinsi_id').select2({
    allowClear: true,
    placeholder: "Pilih Provinsi",
    ajax: {
    url: '{{route("list-provinsi")}}',
    type: "POST",
    dataType: 'json',
        data: function(params) {
            return {
            "_token": "{{ csrf_token() }}",
            search: params.term
            }
        },
        processResults: function (data, page) {
            return {
            results: data
            };
        }
    },
})

$('#kabupaten_id').select2({
    allowClear: true,
    placeholder: "Pilih Kabupaten",

    ajax: {
    url: '{{route("list-kabupaten")}}',
    type: "POST",
    dataType: 'json',
        data: function(params) {
            return {
            "_token": "{{ csrf_token() }}",
            id_provinsi : $('#provinsi_id').val(), 
            search: params.term
            }
        },
        processResults: function (data, page) {
            return {
            results: data
            };
        }
    },

});

$('#kecamatan_id').select2({
    allowClear: true,
    placeholder: "Pilih Kecamatan",
    ajax: {
    url: '{{route("list-kecamatan")}}',
    type: "POST",
    dataType: 'json',
        data: function(params) {
            return {
            "_token": "{{ csrf_token() }}",
            id_kabupaten : $('#kabupaten_id').val(), 
            search: params.term
            }
        },
        processResults: function (data, page) {
            return {
            results: data
            };
        }
    },

});

$('#desa_id').select2({
    allowClear: true,
    placeholder: "Pilih Desa",

    ajax: {
    url: '{{route("list-desa")}}',
    type: "POST",
    dataType: 'json',
        data: function(params) {
            return {
            "_token": "{{ csrf_token() }}",
            id_kecamatan : $('#kecamatan_id').val(), 
            search: params.term
            }
        },
        processResults: function (data, page) {
            return {
            results: data
            };
        }
    },

});


});

</script>

@endpush