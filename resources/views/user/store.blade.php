@extends('master')

@section('title', '')

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

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>Terdapat Kesalahan Pada Pengisian</li> {{ $error }}
            @endforeach
        </ul>
    </div>
    @endif

    <form method="post" action="{{ route('store-user') }}">

        @csrf

        <div class="form-group">
            <label>NIK</label>
            <input type="text" class="form-control" value="" name="nik">
            @if ($errors->has('nik'))
                <div class="error"><p style="color: red"><span>&#42;</span> {{ $errors->first('nik') }}</p></div>
            @endif
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="text" class="form-control" value="" name="email">
            @if ($errors->has('username'))
                <div class="email"><p style="color: red"><span>&#42;</span> {{ $errors->first('email') }}</p></div>
            @endif
        </div>

        <div class="form-group">
            <label>Nama</label>
            <input type="text" class="form-control" value="" name="nama">
            @if ($errors->has('nama'))
                <div class="email"><p style="color: red"><span>&#42;</span> {{ $errors->first('nama') }}</p></div>
            @endif
        </div>

        <div class="form-group">
            <label>Nomor HP</label>
            <input type="text" class="form-control" value="" name="nomor_hp">
            @if ($errors->has('nomor_hp'))
                <div class="error"><p style="color: red"><span>&#42;</span> {{ $errors->first('nomor_hp') }}</p></div>
            @endif
        </div>

        <div class="form-group">
            <label>101. Provinsi</label>
            <select style="width: 100%" class="form-control form-control-user select2-class" name="provinsi_id" id="provinsi_id"></select>
        </div>

        <div class="form-group">
        <label>102. Kabupaten/Kota</label>
        <select style="width: 100%" class="form-control form-control-user select2-class" name="kabupaten_id" id="kabupaten_id"></select>
        </div>

        <div class="form-group">
            <label for="sel1">Tipe Akun</label>
            <select class="form-control" id="account_type" name="account_type">
            <option value="{{ User::ACCOUNT_TYPE_ADMIN }}">Admin</option>           
            <option value="{{ User::ACCOUNT_TYPE_PEGAWAI }}">Pegawai</option>            
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

function setNullPs()
{
    $('#id_ps').val(null);
    $('#kecamatan_id').val(null);
}

function setNullPtl()
{
    $('#id_ptl').val(null);
    $('#kecamatan_id').val(null);
}

$( document ).ready(function() {

$('#account_type').val(null);

$('#kecamatan_dropdown').hide();


$('#provinsi_id').select2({
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


$('#provinsi_id').on('select2:select', function (e) {

    var id_provinsi = $(this).val();

    $('#kabupaten_id').select2({
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

$('#kabupaten_id').on('select2:select', function (e) {
    
    var id_kabupaten = $(this).val();
    
    $('#kecamatan_id').select2({
    allowClear: true,
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

})

</script>

@endpush