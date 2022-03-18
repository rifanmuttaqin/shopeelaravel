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
            
            <form  method="post" action="{{route('beritaacara-destroy')}}" enctype="multipart/form-data">
            
            @csrf
            
            <input type="hidden" value="{{ $data->id}}" name="id">

            <div class="form-group">
                <label>Tanggal</label>
                <input type="text" disabled class="form-control form-control-user" name ="tanggal" id="tanggal" value="{{ $data->tanggal }}">
            </div>

            <div class="form-group">
                <label>Detail Kejadian</label>
                <textarea disabled type="text" class="form-control form-control-user" name ="detail_kejadian" id="detail_kejadian"> {{ $data->detail_kejadian }} </textarea>
            </div>

            <div class="form-group">
                <label>Transaksi</label>
                <input type="text" disabled class="form-control form-control-user" name ="transaksi_id" id="transaksi_id" value="{{ $transaksi_service->findById($data->transaksi_id)->no_resi }}">
            </div>

            <div class="form-group">
                <label>Status Permasalahan</label>
                <input  disabled value="{{ $berita_acara_service->statusMasalahMeaning($data->status_masalah) }}" type="text" class="form-control form-control-user" placeholder="">
            </div>

            <div class="form-group">
                <label>Status</label>
                <input @if(!$data->status_aktif) style={{"background-color:#c89f9f"}} @endif disabled value="@if($data->status_aktif) {{'AKTIF'}} @else {{'TIDAK AKTIF'}} @endif" type="text" class="form-control form-control-user" placeholder="">
            </div>

            <p>
                <h5 style="font-family: 'Times New Roman', Times, serif; color: red"> anda yakin untuk menghapus data ini ? data yg telah dihapus tidak dapat untuk dikembalikan. </h5>
            </p>

            <div class="form-group" style="padding-top: 20px">
                    <a class="btn btn-warning" href="{{ route('beritaacara') }}">Kembali</a>
                    <button type="submit" class="btn btn-danger"> Delete </button>
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

$(function () { })

</script>

@endpush