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

    

  
        
    </div>
    </div>
</div>
</div>


@endsection

@section('modal')

<div class="modal fade" id="ModalProduk" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      
        <div class="modal-body">
     
          <div class="form-group">
            <label>Username</label>
            <input type="text" class="form-control" disabled id="username">
          </div>

          <div class="form-group">
            <label>Detail Produk yang dipesan</label>
            <textarea type="text" class="form-control" disabled id="pesanan"> </textarea>
          </div>

        </div>

    </div>
  </div>
</div>

@endsection


@push('scripts')

<script type="text/javascript">

$(function () {

});

</script>

@endpush