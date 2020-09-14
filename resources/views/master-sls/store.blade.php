@extends('master')

@section('title', 'Tambah Master SLS')

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
                <h4>{{$title}}</h4>
            </div>
            <div class="card-body">
            
            <form class="user" method="post" action="{{ route('master-sls-store') }}">

                @csrf

                <div class="form-group">
                <label><small>ID SLS</small></label>
                    <input type="text" class="form-control" value="" name="id_sls">
                    @if ($errors->has('id_sls'))
                        <small><p style="color: red"><span>&#42;</span> {{ $errors->first('id_sls') }}</p></small>
                    @endif
                </div>
                
                <div class="form-group row">
                    <div class="col-sm-4 mb-3 mb-sm-0">
                    <label><small>ID SLS Non</small></label>
                    <input type="text" class="form-control" name="id_sls_non" id="id_sls_non">
                    </div>
                    <div class="col-sm-4 ">
                    <label><small>ID SLS Non Satu Digit</small></label>
                    <input type="text" class="form-control" name="id_sls_non_satu_digit" id="id_sls_non_satu_digit">
                    </div>
                    <div class="col-sm-4">
                    <label><small>105. Nama SLS/Non SLS</small></label>
                    <input type="text" class="form-control" name="nama_sls_non" id="nama_sls_non">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                    <label><small>FSUB</small></label>
                    <input type="text" class="form-control" name="fsub" id="fsub">
                    </div>
                    <div class="col-sm-6">
                    <label><small>Nama Ketua SLS</small></label>
                    <input type="text" class="form-control" name="nama_ketua_sls" id="nama_ketua_sls">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                    <label><small>J MSLS 30</small></label>
                    <input type="text" class="form-control" name="j_msls_30" id="j_msls_30">
                    </div>
                    <div class="col-sm-6">
                    <label><small>Max</small></label>
                    <input type="text" class="form-control" name="max" id="max">
                    </div>
                </div>

                <div class="form-group">
                    <label><small>Belum</small></label>
                    <input type="text" class="form-control" value="" id="belum" name="belum">
                    @if ($errors->has('belum'))
                        <small><p style="color: red"><span>&#42;</span> {{ $errors->first('belum') }}</p></small>
                    @endif
                </div>

                <div class="form-group row">
                    <div class="col-sm-3 mb-3 mb-sm-0">
                    <label><small>Konfirmasi Bulan Lahir</small></label>
                    <input type="text" class="form-control" name="konfirmasi_bulan_lahir" id="konfirmasi_bulan_lahir">
                    </div>
                    <div class="col-sm-3">
                    <label><small>Konfirmasi Tanggal Lahir</small></label>
                    <input type="text" class="form-control" name="konfirmasi_tanggal_lahir" id="konfirmasi_tanggal_lahir">
                    </div>
                    <div class="col-sm-3">
                    <label><small>Konfirmasi Tahun Lahir</small></label>
                    <input type="text" class="form-control" name="konfirmasi_tahun_lahir" id="konfirmasi_tahun_lahir">
                    </div>
                    <div class="col-sm-3">
                    <label><small>Konfirmasi Jenis Kelamin</small></label>
                    <input type="text" class="form-control" name="konfirmasi_jenis_kelamin" id="konfirmasi_jenis_kelamin">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-4 mb-3 mb-sm-0">
                    <label><small>Pindah</small></label>
                    <input type="text" class="form-control" name="pindah" id="pindah">
                    </div>
                    <div class="col-sm-4">
                    <label><small>Sudah</small></label>
                    <input type="text" class="form-control" name="sudah" id="sudah">
                    </div>
                    <div class="col-sm-4">
                    <label><small>Ulang</small></label>
                    <input type="text" class="form-control" name="ulang" id="ulang">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-4 mb-3 mb-sm-0">
                    <label><small>Grand Total</small></label>
                    <input type="text" disabled="true" class="form-control" name="grand_total" id="grand_total">
                    </div>
                    <div class="col-sm-4">
                    <label><small>TBK SLS</small></label>
                    <input type="text" disabled="true" class="form-control" name="tbk_sls" id="tbk_sls">
                    </div>
                    <div class="col-sm-4">
                    <label><small>Target C1</small></label>
                    <input type="text" disabled="true" class="form-control" name="target_c1" id="target_c1">
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
                    <button type="submit" class="btn btn-info"> TAMBAH </button>
                </div>

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
    }
})

$('#kabupaten_id').select2({
    allowClear: true,
    placeholder: "Pilih Kabupaten",
});

$('#kecamatan_id').select2({
    allowClear: true,
    placeholder: "Pilih Kecamatan",
});

$('#desa_id').select2({
    allowClear: true,
    placeholder: "Pilih Desa",
});



$('#provinsi_id').on('select2:select', function (e) {

var id_provinsi = $(this).val();

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
                search: params.term,
                id_provinsi : id_provinsi,     
                }
            },
            processResults: function (data, page) {
                return {
                results: data
                };
            }
        }
    })
});

$('#kabupaten_id').on('select2:select', function (e) {

    var id_kabupaten = $(this).val();

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
            search: params.term,
            id_kabupaten : id_kabupaten,     
            }
        },
        processResults: function (data, page) {
            return {
            results: data
            };
        }
        }
    })
});


$('#kecamatan_id').on('select2:select', function (e) {

    var id_kecamatan = $(this).val();

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
                search: params.term,
                id_kecamatan : id_kecamatan,     
                }
            },
            processResults: function (data, page) {
                return {
                results: data
                };
            }
        }
    })
});


})

</script>

@endpush