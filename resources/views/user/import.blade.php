<!-- Tambah dirubah dari submit ke AJAX -->

@extends('master')
 
@section('title', 'Import User')

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
        <h4>{{ $title }}</h4>
    </div>
    <div class="card-body">

    <form  method="post" action="{{ route('do-import-user') }}" enctype="multipart/form-data">

        @csrf
        
        <hr>
            <div style="margin:0 auto;text-align:center">
                <button id="popup_info" type="button" class="btn btn-info"> Informasi Data Import </button>
            </div>
        </hr>

        <hr>
        <div style="margin:0 auto;text-align:center">
            <h5> <p> Silahkan download template file Terlebih dahulu : </p></h5>
            <a href="{{ url('/import_layout/user.xlsx') }}"> <i class="far fa-file-excel"></i> &nbsp Download </a>
        </div>
        <hr>

        <!-- Upload Form  -->
        <div style="margin:0 auto;text-align:center">
            <div id="upload" style="">
                <input type="file" name="file" id="file" class="inputfile" accept="xls,xlsx"/>
                <label for="file"> &nbsp <i class="fas fa-file-upload"></i> Upload File &nbsp </label>
                <p id="filename"></p>
                <p> File Max. 2 MB </p>
            </div>
        </div>

        <div style="padding-bottom: 20px">
            <button type="submit" id="proses" class="btn btn-info"> IMPORT </button>
        </div>

        </form>	

    </div>
    </div>
</div>
</div>

	
@endsection

@section('modal')

<div class="modal fade" id="createModal" role="dialog" >
<div class="modal-dialog modal-md">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    <div class="modal-body">

        <div class="form-group">
        <label>101. Provinsi</label>
            <select style="width: 100%" class="form-control form-control-user select2-class" name="provinsi_add" id="provinsi_add">
            </select>
        </div>

        <div class="form-group">
        <label>102. Kabupaten/Kota</label>
            <select style="width: 100%" class="form-control form-control-user select2-class" name="kabupaten_add" id="kabupaten_add">
            </select>
        </div>

    <hr>
        <p> Kode Provinsi : <a id="provinsi_info"></a> </p>
        <p> Kode Kabupaten : <a id="kabupaten_info"></a> </p>
    <hr>
    <p> <strong>Tipe Akun </strong> </p>
    <ul>
            <li> Admin </li>
            <li> Pegawai </li> 
    </ul>

    </div>
    <div class="modal-footer"></div>
  </div>
</div>
</div>

@endsection

@push('scripts')

<script type="text/javascript">


$( document ).ready(function() {

$( "#proses" ).click(function() {
    swal('Mohon tunggu sebentar prosess import dilakukan .......', { button:false, closeOnClickOutside:false});
});

$('#provinsi_add').select2({
    allowClear: true,
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

$('#kabupaten_add').on('select2:select', function (e) {
    
    var id_kabupaten = $(this).val();

    $("#kabupaten_info").html($('#kabupaten_add').select2('data')[0].kode_kabupaten);

});

$('#provinsi_add').on('select2:select', function (e) {
    
    var id_provinsi = $(this).val();
    
    $("#provinsi_info").html($('#provinsi_add').select2('data')[0].kode_provinsi);
    
    $('#kabupaten_add').select2({
    allowClear: true,
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

$('#popup_info').click(function() {
    $('#createModal').modal('toggle');
});

$('#file').change(function() {
    var filename = $('#file').val();
    $('#filename').html(filename);
})

});

</script>

@endpush