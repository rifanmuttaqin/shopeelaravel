<!-- Tambah dirubah dari submit ke AJAX -->

@extends('master')
 
@section('title', 'Master SLS')

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
        <h4>{{$title}}</h4>
    </div>
    <div class="card-body">
        
        <div style="padding-bottom: 20px">
        <a  href="{{route('master-sls-create')}}" type="button" id="btnTambah" class="btn btn-info"> TAMBAH </a>
        </div>

        <div class="form-group row">
            <div class="col-sm-3 mb-3 mb-sm-0">
            <label><small>101. Provinsi</small></label>
            <select style="width: 100%"  class="form-control select2-class" name="provinsi_id" id="provinsi_id">
            </select>
            </div>
            <div class="col-sm-3">
            <label><small>102. Kabupaten/Kota</small></label>
            <select style="width: 100%" class="form-control select2-class" name="kabupaten_id" id="kabupaten_id">
            </select>
            </div>
            <div class="col-sm-3">
            <label><small>103. Kecamatan</small></label>
            <select style="width: 100%" class="form-control select2-class" name="kecamatan_id" id="kecamatan_id">
            </select>
            </div>
            <div class="col-sm-3">
            <label><small>104. Desa</small></label>
            <select style="width: 100%" class="form-control select2-class" name="desa_id" id="desa_id">
            </select>
            </div>
        </div>

        <hr>

        <div class="table-responsive">
        <table class="table table-bordered data-table display nowrap" style="width:100%">
            <thead style="text-align:center;">
                <tr>
                    <th>No</th>
                    <th>ID SLS</th>
                    <th>Kabupaten</th>
                    <th>Kecamatan</th>
                    <th>Desa</th>
                    <th>Nama SLS NON</th>
                    <th width="100px">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
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

var idmastersls;
var table;

$(function () {

    table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        responsive: true,
        ajax: "{{ route('master-sls') }}",
        columns: [
            {data: 'rownum', name: 'rownum', searchable: false},
            {data: 'id_sls', name: 'id_sls'},
            {data: 'nama_kabupaten', name: 'tbl_kabupaten.nama_kabupaten'},
            {data: 'nama_kecamatan', name: 'tbl_kecamatan.nama_kecamatan'},
            {data: 'nama_desa', name: 'tbl_desa.nama_desa'},
            {data: 'nama_sls_non', name: 'nama_sls_non'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        'columnDefs'        : [         // see https://datatables.net/reference/option/columns.searchable
            {
                'targets': [0],
                'className': 'dt-body-center'
            }
        ],
    });
 
    $('#provinsi_id').select2({
        allowClear: true,
        placeholder: "Pilih Provinsi",
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

    $('#kabupaten_id').select2({
        allowClear: true,
        placeholder: "Pilih Kabupaten",
    });

    $('#kecamatan_id').select2({
        allowClear: true,
        placeholder: "Pilih Kecamatan",
    });

    $('#desa_id').select2({
        allowClear: true,
        placeholder: "Pilih Desa",
    });

    $('#provinsi_id').on('select2:select', function (e) {

    var id_provinsi = $(this).val();

    $('#kabupaten_id').select2({
        allowClear: true,
        placeholder: "Pilih Kabupaten",
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
        
        var id_kabupaten        =  $(this).val();   
        var kabupaten_name      = $("#kabupaten_id").select2('data');
        
        table
        .columns( 2 )
        .search(kabupaten_name[0].text).draw() ;
                       
        $('#kecamatan_id').select2({
            allowClear: true,
            placeholder: "Pilih Kecamatan",
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

    $('#kecamatan_id').on('select2:select', function (e) {

        var id_kecamatan        = $(this).val();
        var kecamatan_name      = $("#kecamatan_id").select2('data');
        
        table
        .columns( 3 )
        .search(kecamatan_name[0].text).draw() ;

        $('#desa_id').select2({
            allowClear: true,
            placeholder: "Pilih Desa",
            ajax: {
                url: '{{route("list-desa")}}',
                type: "POST",
                dataType: 'json',
                data: function(params) {
                    return {
                    "_token": "{{ csrf_token() }}",
                    search: params.term,
                    id_kecamatan : id_kecamatan,     
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

    $('#desa_id').on('select2:select', function (e) {
        
        var desa_name      = $("#desa_id").select2('data');
        
        table
        .columns( 4 )
        .search(desa_name[0].text).draw() ;    
    
    });

});


function btnUbah(id)
{
    idmastersls = id;
    
    var url = '{{ route("master-sls-edit", ":id") }}';
    url     = url.replace(':id', idmastersls);
    window.location.href = url;
}

function btnDel(id)
{
    idmastersls = id;
    hapus(idmastersls);
}

function btnUnlock(id)
{
    idmastersls = id;
    unlock(idmastersls);
}

function unlock(idmastersls)
{
    swal({
        title: "Apakah anda yakin ingin membuka SLS ini ?",
        text: 'Jika anda melakukan pembukaan, maka SLS terpilih dapat dilakukan update kembali', 
        icon: "info",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
    if (willDelete) {
        $.ajax({
        type:'POST',
        url: '{{route("master-sls-unlock")}}',
        data:{
            idmastersls:idmastersls, 
            "_token": "{{ csrf_token() }}",},
        success:function(data) {
            
            if(data.status != false)
            {
            swal(data.message, { button:false, icon: "success", timer: 1000});
            }
            else
            {
            swal(data.message, { button:false, icon: "error", timer: 1000});
            }

            table.ajax.reload();
        },

        error: function(error) 
        {
            swal('Terjadi kegagalan sistem', { button:false, icon: "error", timer: 1000});
        }

        });      
    }
    });
}

function hapus(idmastersls)
{
  swal({
      title: "Apakah anda yakin ingin menghapus ini ?",
      text: 'Jika terdapat data yang digunakan, maka proses hapus ini tidak dapat dilakukan', 
      icon: "warning",
      buttons: true,
      dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {
      $.ajax({
        type:'POST',
        url: '{{route("master-sls-destroy")}}',
        data:{
            idmastersls:idmastersls, 
          "_token": "{{ csrf_token() }}",},
        success:function(data) {
          
          if(data.status != false)
          {
            swal(data.message, { button:false, icon: "success", timer: 1000});
          }
          else
          {
            swal(data.message, { button:false, icon: "error", timer: 1000});
          }
          table.ajax.reload();
        },
        error: function(error) {
          swal('Terjadi kegagalan sistem', { button:false, icon: "error", timer: 1000});
        }
      });      
    }
  });
}

</script>

@endpush