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
                  
            <div class="form-group">
                  <label>Nama</label>
                  <input type="text" disabled class="form-control form-control-user" value="{{ $data_supplier->nama }}">
            </div>

            <div class="form-group">
                  <label>Kontak</label>
                  <input type="text" disabled class="form-control form-control-user" value="{{ $data_supplier->kontak }}">
            </div>

            <div class="form-group">
                  <label>Alamat</label>
                  <input type="text" disabled class="form-control form-control-user" value="{{ $data_supplier->alamat }}">
            </div> 
            
            
            <div class="form-group">
                  <label>Keterangan</label>
                  <input type="text" disabled class="form-control form-control-user" value="{{ $data_supplier->keterangan }}">
            </div> 

            <div class="form-group">
                  <label>Status</label>
                  <input @if(!$data_supplier->status_aktif) style={{"background-color:#c89f9f"}} @endif disabled value="@if($data_supplier->status_aktif) {{'AKTIF'}} @else {{'TIDAK AKTIF'}} @endif" type="text" class="form-control form-control-user" placeholder="">
            </div>

            <table class="table table-striped" style="width: 50%">
            <tbody>
                  <tr>
                        <td>Dibuat pada</td>
                        <td>{{ date_format($data_supplier->created_at,"d F Y H:i:s") }}</td>
                  </tr>

                  <tr>
                        <td>Terakhir diupdate</td>
                        <td>{{ date_format($data_supplier->updated_at,"d F Y H:i:s") }}</td>
                  </tr>
            </tbody>
            </table>

            <div class="form-group" style="padding-top: 20px">
                  <a class="btn btn-warning" href="{{ route('supplier') }}">Kembali</a>
            </div>

            
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


})

</script>

@endpush