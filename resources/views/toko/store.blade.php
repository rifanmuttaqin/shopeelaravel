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

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>Terdapat Kesalahan Pada Pengisian</li> {{ $error }}
            @endforeach
        </ul>
    </div>
    @endif

    <form method="post" action="{{ route('toko-store') }}">

        @csrf

        <div class="form-group">
            <label>Nama Toko</label>
            <input type="text" class="form-control" value="" name="nama_toko">
            @if ($errors->has('nama_toko'))
                <div><p style="color: red"><span>&#42;</span> {{ $errors->first('nama_toko') }}</p></div>
            @endif
        </div>

        <div class="form-group">
            <label>Alamat Toko</label>
            <input type="text" class="form-control" value="" name="alamat_toko">
            @if ($errors->has('alamat_toko'))
                <div><p style="color: red"><span>&#42;</span> {{ $errors->first('alamat_toko') }}</p></div>
            @endif
        </div>

        <div class="form-group">
            <label>Link Shopee</label>
            <input type="text" class="form-control" value="" name="link_shopee">
            @if ($errors->has('link_shopee'))
                <div><p style="color: red"><span>&#42;</span> {{ $errors->first('link_shopee') }}</p></div>
            @endif
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

</script>

@endpush