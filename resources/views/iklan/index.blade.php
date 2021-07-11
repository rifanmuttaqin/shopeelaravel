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

            <div class="container">
                  <div class="row">
                    <div class="col-sm-6" style="padding-left:0px">
                        <div class="form-group" >
                              <a class="btn btn-info" data-toggle="collapse" href="#collapseData" role="button" aria-expanded="false" aria-controls="collapseData">
                                    Form Iklan &nbsp <i class="fas fa-chevron-up"></i>
                              </a>
                        </div>
                    </div>
                  </div>
            </div>

            <div class="collapse" id="collapseData">
                  
                  <form method="post" action="">

                  @csrf
          
                  <div class="form-group">
                        <label for="sel1" style="color: rgb(85, 82, 82)"><strong>Toko</strong></label>
                        <select class="form-control" id="user_toko_id" name="user_toko_id">
                            <option value=""> ------ PILIH TOKO -------------- </option>  
                            @foreach ($daftar_toko as $toko)
                                <option value="{{$toko->id}}">{{ $toko->nama_toko }}</option>  
                            @endforeach                 
                        </select>
                  </div>

                  <div class="form-group">
                        <label>Total Iklan</label>
                        <input type="text" class="form-control" name="total_iklan" id="total_iklan">
                  </div>

                  <div class="form-group">
                        <label>Tanggal Pembelian</label>
                        <input type="date" class="form-control" name="date" id="date">
                  </div>
          
          
                  <div class="form-group">
                      <button type="button" id="prosess" class="btn btn-info"> TAMBAH </button>
                  </div>
          
                  </form>
            
            </div>

            <hr>

            <div class="form-group row">
                  <div class="col-sm-12">
                        <label><small>Periode Transaki</small></label>
                        <input type="text" class="form-control" name="dates" id="dates">
                  </div>
            </div>

      
      </div>
      <div class="card-body">
            <div style="width: 100%; padding-left: -10px;">
            <div class="table-responsive">
            <table id="table_result" class="table table-bordered data-table display nowrap" style="width:100%">
            <thead style="text-align:center;">
                  <tr>
                        <th style="width: 10%">Nama Toko</th>
                        <th style="width: 50%">Total Iklan</th>
                        <th style="width: 50%">Tanggal Beli</th>
                        <th style="width: 30%">Aksi</th>
                  </tr>
            </thead>
            </table>
            </div>
            </div>
      </div>
</div>

@endsection

@section('modal')



@endsection


@push('scripts')

<script type="text/javascript">

var token = "{{ csrf_token() }}";

function clearAll()
{
      $('#user_toko_id').val(null);
      $('#total_iklan').val(null);
      $('#date').val(null);
}

function btnDel(id)
{
      var url   = "{{route('destroy-iklan')}}";
      var token = "{{ csrf_token() }}";
      swalConfrim("Menghapus Data","Data yang telah dihapus tidak dapat untuk dikembalikan",id,url,token);
}


$(function () {
      table = $('#table_result').DataTable({
            processing: true,
            serverSide: true,
            rowReorder: {
                  selector: 'td:nth-child(2)'
            },
            responsive: true,
            ajax: "#",
            columns: [
                  {data: 'user_toko_id', name: 'user_toko_id'},
                  {data: 'total_iklan', name: 'total_iklan'},
                  {data: 'date', name: 'date'},
                  {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
      });

      $('input[name="dates"]').daterangepicker({
            autoUpdateInput: true,
            locale: { cancelLabel: 'Bersihkan' }
      }).on("change", function() {

            $.ajax({
                  type:'GET',
                  url: '#',
                  data:
                  {
                        "_token": "{{ csrf_token() }}",
                        date : this.value,
                  },
                  success:function(data) {
                        table.ajax.reload();
                  }
            });
            
            // console.log(this.value);
      });

      $( "#prosess" ).click(function() {

            var param = null;
            var url   = "{{route('store-iklan')}}";

            param     = { 
                  user_toko_id :$('#user_toko_id').val(),
                  total_iklan :$('#total_iklan').val(),
                  date :$('#date').val(),
            };

            setAjaxInsert(url, param, token);
      });


});

</script>

@endpush