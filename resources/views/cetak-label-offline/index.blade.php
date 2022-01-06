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

        <div class="form-group">
        <label>Customer</label>
        <select style="width: 100%" multiple="multiple" class="form-control form-control-user select2-class" name="customer[]" id="customer">
        </select>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-info" id="cetakData"> Cetak </button>
        </div>

    </form>
     
    </div>
</div>
</div>
</div>

@endsection


@push('scripts')

<script type="text/javascript">

$( document ).ready(function() {

    $('#customer').select2({
        allowClear: true,
        ajax: {
        url: '{{route("customer-offline-list")}}',
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

});

</script>

@endpush