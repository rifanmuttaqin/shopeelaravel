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

            <form  method="post" action="{{ route('beritaacara-store')}}" enctype="multipart/form-data">

                  @csrf
                  
                    <div class="form-group">
                            <label>Tanggal</label>
                            <input type="text" class="form-control form-control-user" name ="tanggal" id="tanggal" placeholder="">
                            <small> Isi dengan tanggal pelaporan </small>
                            @if ($errors->has('tanggal'))
                                <div><p style="color: red"><span>&#42;</span> {{ $errors->first('tanggal') }}</p></div>
                            @endif
                    </div>

                    <div class="form-group">
                    <label>Detail Kejadian</label>
                    <textarea type="text" class="form-control form-control-user" name ="detail_kejadian" id="detail_kejadian"></textarea>
                    <small> Isi dengan detail kejadian </small>
                    @if ($errors->has('detail_kejadian'))
                        <div><p style="color: red"><span>&#42;</span> {{ $errors->first('detail_kejadian') }}</p></div>
                    @endif
                    </div>

                    
                    <div class="form-group">
                    <label>Transaksi</label>
                        <select style="width: 100%" class="form-control form-control-user select2-class" name="transaksi_id" id="transaksi_id">
                        </select>
                    </div>

                    <div style="margin:0 auto;text-align:center">
                        <p> Gambar / Foto Pendukung yang dapat dilampirkan</p>
                    </div>
            
                    <!-- Upload Form  -->
                    <div style="margin:0 auto;text-align:center">
                        <div id="upload" style="">
                            <input type="file" name="file" id="file" class="inputfile"/>
                            <label for="file"> &nbsp <i class="fas fa-file-upload"></i> Upload File &nbsp </label>
                            <p id="filename"></p>
                            <p> File Max. 2 MB </p>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Nominal Kerugian (Taksiran)</label>
                        <input type="text" class="form-control form-control-user" name ="nominal_kerugian" id="nominal_kerugian" placeholder="">
                        <small> Isi dengan nominal kerugian </small>
                        @if ($errors->has('nominal_kerugian'))
                            <div><p style="color: red"><span>&#42;</span> {{ $errors->first('nominal_kerugian') }}</p></div>
                        @endif
                    </div>

                    <div class="form-group">
                    <label>Status Permasalahan</label>
                    <select name="status_masalah" class="form-control">
                            <option value="10">Aktif</option>
                            <option value="20">Pending</option>
                            <option value="30">Selesai</option>
                    </select>
                    <small> Hanya data dengan status Aktif yang terpakai dalam program </small>
                    @if ($errors->has('status_aktif'))
                            <div><p style="color: red"><span>&#42;</span> {{ $errors->first('status_aktif') }}</p></div>
                    @endif
                    </div>
                
                  <div class="form-group">
                  <label>Status Aktif</label>
                  <select name="status_aktif" class="form-control">
                        <option value="1">Aktif</option>
                        <option value="0">Tidak Aktif</option>
                  </select>
                  <small> Hanya data dengan status Aktif yang terpakai dalam program </small>
                  @if ($errors->has('status_aktif'))
                        <div><p style="color: red"><span>&#42;</span> {{ $errors->first('status_aktif') }}</p></div>
                  @endif
                  </div>

                  <div class="form-group" style="padding-top: 20px">
                        <button type="submit" class="btn btn-info"> Submit </button>
                  </div>


            </form>	
            
      </div>

      </div>
</div>
</div>

@endsection

@section('modal')


@endsection

@push('scripts')

<script type="text/javascript">

$(function () {

    $('#file').change(function() {
        var filename = $('#file').val();
        $('#filename').html(filename);
    })

    $('#tanggal').daterangepicker({
        autoUpdateInput: true,
        singleDatePicker: true,
        format: 'MM/DD/YYYY',
        locale: { cancelLabel: 'Bersihkan' }
    });

    $('#transaksi_id').select2({
        allowClear: true,
        ajax: {
        url: '{{route("transaksi-list")}}',
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

})

</script>

@endpush