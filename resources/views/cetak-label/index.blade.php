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
        <h4>{{ $title }}</h4>
    </div>
    <div class="card-body">

    <form method="post" action="{{ route('do-cetak-label') }}">
    @csrf

    <div class="form-group row">
    <div class="col-sm-12">
        <label><small>Periode Transaki</small></label>
        <input type="text" class="form-control" name="dates" id="dates">
        </div>
    </div>

    <div class="form-group">
        <label for="sel1">Status Cetak</label>
        <select class="form-control" id="type_cetak" name="type_cetak">
        <option value="BELUM">BELUM DI CETAK</option> 
        <option value="SEMUA">SEMUA</option>                   
        </select>
    </div>

    <div class="form-group">
    <label>Pilihan Toko (<small>kosongkan jika default</small>)</label>
      <select style="width: 100%" class="form-control form-control-user select2-class" name="toko" id="toko">
      </select>
    </div>

    <div class="form-group">
        <button type="button" class="btn btn-info" id="previewData"> Tampilkan List </button>
        <button type="submit" class="btn btn-info" id="cetakData"> Cetak </button>
    </div>

    </form>

    <div id="table_result">
        <table class="table table-bordered data-table display nowrap" style="width:100%">
        <thead style="text-align:center;">
            <tr>
                <th>Nomor Resi</th>
                <th>Username</th>
                <th>Status Cetak</th>
            </tr>
        </thead>
        </table>
    </div>
     
</div>
</div>

@endsection

@push('scripts')

<script type="text/javascript">

$( document ).ready(function() {


    // select2-class
    $('#toko').select2({
        allowClear: true,
        ajax: {
        url: '{{route("toko-list")}}',
        type: "POST",
        dataType: 'json',
            data: function(params) {
                return {
                  "_token": "{{ csrf_token() }}",
                  search: params.term,
                }
            },
            processResults: function (data, page) {
                return {
                results: data
                };
            }
        }
    })


    $('#table_result').hide();
    $('#cetakData').hide();

    var table;
    
    $('input[name="dates"]').daterangepicker();

    $('#previewData').click(function() {

        var param = 
        {
            dates : $('#dates').val(),
            type_cetak : $('#type_cetak').val(),
            toko : $('#toko').val(),
            "_token": "{{ csrf_token() }}",
        };

        table = $('.data-table').DataTable({
        
            ajax: 
            {
                "url": '{{route("preview-cetak")}}',
                "type": "POST",
                data: param,
                dataSrc: function ( json ) 
                {
                    $('#table_result').show();
                    $('#cetakData').show();
                    return json.data;
                }     
            },

            destroy: true,
            responsive: true,
            searching: false,
            serverSide: true,
            columns: [
                {data: 'no_resi', name: 'no_resi'},
                {data: 'username_pembeli', name: 'username_pembeli'},
                {data: 'status_cetak', name: 'status_cetak'},
            ],

        });
    })

});

</script>

@endpush