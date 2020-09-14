@extends('master')
 
@section('title', 'Manajemen User')

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

    <div style="padding-bottom: 20px">
      <a  href="{{ route('create-user') }}" type="button" class="btn btn-info"> TAMBAH </a>
    </div>

    <div style="width: 100%; padding-left: -10px;">
      <div class="table-responsive">
      <table id="user_table" class="table table-bordered data-table display nowrap" style="width:100%">
      <thead style="text-align:center;">
          <tr>
              <th>NIK</th>
              <th>Nama</th>
              <th>Tipe Akun</th>
              <th>Provinsi</th>
              <th>Kabupaten</th>
              <th>Action</th>
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
</div>


@endsection

@section('modal')

<div class="modal fade" id="detailModal" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">

    <div class="form-group">
      <label>NIK</label>
      <input type="text" class="form-control" value="" id="nik">
    </div>

    <div class="form-group">
      <label>Email</label>
      <input type="text" class="form-control" value="" id="email">
    </div>

    <div class="form-group">
      <label>Nama</label>
      <input type="text" class="form-control" value="" id="nama">
    </div>

    <div class="form-group">
      <label>Nomor HP</label>
      <input type="text" class="form-control" value="" id="nomor_hp">
    </div>

    <div class="form-group">
    <label>101. Provinsi</label>
        <select style="width: 100%" class="form-control form-control-user select2-class" name="provinsi_edit" id="provinsi_edit">
        </select>
    </div>

    <div class="form-group">
    <label>102. Kabupaten/Kota</label>
        <select style="width: 100%" class="form-control form-control-user select2-class" name="kabupaten_edit" id="kabupaten_edit">
        </select>
    </div>

      
    <div class="form-group">
      <label for="sel1">Tipe Akun</label>
      <select class="form-control" id="tipe_akun">
        <option value="{{ User::ACCOUNT_TYPE_ADMIN }}" >Admin</option>
        <option value="{{ User::ACCOUNT_TYPE_PEGAWAI }}">Pegawai</option>
      </select>
    </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-right" id="non_aktif_button">Non Aktifkan</button>
        <button type="button" id="update_data" class="btn btn-default pull-left">Update</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="updatePassword" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
          <div class="form-group">
            <label>NIK</label>
            <input type="text" class="form-control" value="" id="nik_change_password" disabled>
          </div>

          <div class="form-group">
            <label>Nama</label>
            <input type="text" class="form-control" value="" id="nama_change_password" disabled>
          </div>

          <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" value="" id="password">
          </div>

          <div class="form-group">
            <label>Re Password</label>
            <input type="password" class="form-control" value="" id="password_confirmation">
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" id="update_data_password" class="btn btn-info btn-default pull-left">Update Password</button>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script type="text/javascript">

var iduser;
var table;

function clearAll(){
  $('#username').val('');
  $('#tipe_akun').val('');
  $('#email').val('');
  $('#nama_lengkap').val('');
  $('#alamat').val('');
}

$(function () {
  table = $('#user_table').DataTable({
      processing: true,
      serverSide: true,
      rowReorder: {
          selector: 'td:nth-child(2)'
      },
      responsive: true,
      ajax: "{{ route('index-user') }}",
      columns: [
          {data: 'nik', name: 'nik'},
          {data: 'nama', name: 'nama'},
          {data: 'account_type', name: 'account_type'},
          {data: 'provinsi_id', name: 'provinsi_id'},
          {data: 'kabupaten_id', name: 'kabupaten_id'},
          {data: 'action', name: 'action', orderable: false, searchable: false},
      ]
  });
});

function btnDel(id)
{
  iduser = id;
  
  swal({
      title: "Menon Aktifkan User",
      text: 'User yang telah dinon aktifkan tidak dapat diaktifkan kembali', 
      icon: "warning",
      buttons: true,
      dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {
      $.ajax({
        type:'POST',
        url: '{{route("delete-user")}}',
        data:{
          iduser:iduser, 
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

function btnPass(id){

  $('#updatePassword').modal('toggle');

  iduser = id;

  $.ajax({
     type:'POST',
     url: '{{route("user-detail")}}',
     data:{iduser:iduser, "_token": "{{ csrf_token() }}",},
     success:function(data) {
        $('#nik_change_password').val(data.data.nik);
        $('#nama_change_password').val(data.data.nama);
     },
     error: function(error) {
      swal('Terjadi kegagalan sistem', { button:false, icon: "error", timer: 1000});
    }
  });
}

function ShowPtl()
{
  $('.id_ptl').show();
  $('.id_ps').hide();
  $('#kecamatan_id').show();

  $('#id_ptl').val(null);
}

function ShowPs()
{
  $('.id_ptl').hide();
  $('.id_ps').show();
  $('#kecamatan_id').show();

  $('#id_ps').val(null);
}

function notPSPTL()
{
  $('.id_ptl').hide();
  $('.id_ps').hide();
  $('#kecamatan_id').hide();

  $('#id_ptl').val(null);
  $('#id_ps').val(null);
  $('#kecamatan_edit').val(null);
}

function btnUbah(id){

  $('#detailModal').modal('toggle');
  
  iduser = id;

  $.ajax({
     type:'POST',
     url: '{{route("user-detail")}}',
     data:{iduser:iduser, "_token": "{{ csrf_token() }}",},
     success:function(data) {
        $('#nik').val(data.data.nik);
        $('#email').val(data.data.email);
        $('#nama').val(data.data.nama);
        $('#nomor_hp').val(data.data.nomor_hp);
        $('#tipe_akun').val(data.data.account_type);
             
        $('#id_ptl').val(data.data.id_user);
        $('#id_ps').val(data.data.id_user);

         // Append Data To Select2 Option
          var o = new Option(data.data.nama_provinsi, data.data.provinsi_id);
          $(o).html(data.data.nama_provinsi);
          $("#provinsi_edit").append(o);
          $('#provinsi_edit').val(data.data.provinsi_id).trigger('change')

          // Append Data To Select2 Option
          var o = new Option(data.data.nama_kabupaten, data.data.kabupaten_id);
          $(o).html(data.data.nama_kabupaten);
          $("#kabupaten_edit").append(o);
          $('#kabupaten_edit').val(data.data.kabupaten_id).trigger('change')

          // Append Data To Select2 Option
          var o = new Option(data.data.nama_kecamatan, data.data.kecamatan_id);
          $(o).html(data.data.nama_kecamatan);
          $("#kecamatan_edit").append(o);
          $('#kecamatan_edit').val(data.data.kecamatan_id).trigger('change')

     }
  });

}

$( document ).ready(function() {

$( "#tipe_akun" ).change(function() {
  
});

// Hide Koseka & PTS
$('.id_ptl').hide();
$('.id_ps').hide();

$('#provinsi_edit').select2({
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

$('#kabupaten_edit').select2({
  allowClear: true,
  ajax: {
  url: '{{route("list-kabupaten")}}',
  type: "POST",
  dataType: 'json',
      data: function(params) {
          var id_provinsi = $('#provinsi_edit').val();
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

$('#kecamatan_edit').select2({
allowClear: true,
ajax: {
url: '{{route("list-kecamatan")}}',
type: "POST",
dataType: 'json',
    data: function(params) {
        var id_kabupaten = $('#kabupaten_edit').val();
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

$('#non_aktif_button').click(function() { 
      btnDel(iduser)
      $("#detailModal .close").click()
})

$('#update_data_password').click(function() {

    var password = $('#password').val();
    var password_confirmation = $('#password_confirmation').val();

    $.ajax({
      type:'POST',
      url: '{{route("update-password-user")}}',
      data:
      {
        iduser:iduser, 
        "_token": "{{ csrf_token() }}",
        password : password,
        password_confirmation : password_confirmation,
      },
      success:function(data) {

        if(data.status != false)
        {
          swal(data.message, { button:false, icon: "success", timer: 1000});
          $("#updatePassword .close").click()
        }
        else
        {
          swal(data.message, { button:false, icon: "error", timer: 1000});
        }
      },
        error: function(error) {
          var err = eval("(" + error.responseText + ")");
          var array_1 = $.map(err, function(value, index) {
              return [value];
          });
          var array_2 = $.map(array_1, function(value, index) {
              return [value];
          });
          var message = JSON.stringify(array_2);
          swal(message, { button:false, icon: "error", timer: 1000});
        }
    });
})

$('#update_data').click(function() { 

    var nik           = $('#nik').val();
    var email         = $('#email').val();
    var nama          = $('#nama').val();
    var nomor_hp      = $('#nomor_hp').val();
    var provinsi_id   = $('#provinsi_edit').val();
    var kabupaten_id  = $('#kabupaten_edit').val();
    var account_type  = $('#tipe_akun').val();
    var kecamatan_id  = $('#kecamatan_edit').val();
    var id_ps         = $('#id_ps').val();
    var id_ptl        = $('#id_ptl').val();
  
    $.ajax({
      type:'POST',
      url: '{{route("update-user")}}',
      data:{
        iduser        : iduser, 
        "_token": "{{ csrf_token() }}",
        nik           : nik,
        email         : email,
        nama          : nama,
        nomor_hp      : nomor_hp,
        provinsi_id   : provinsi_id,
        kabupaten_id  : kabupaten_id,
        account_type  : account_type,
        kecamatan_id  : kecamatan_id,
        id_ps         : id_ps,
        id_ptl        : id_ptl
      },
      success:function(data) {
        if(data.status != false)
        {
          console.log('Sucsesss');
          table.ajax.reload();
          swal(data.message, { button:false, icon: "success", timer: 1000});
          $("#detailModal .close").click();
          clearAll();
        }
        else
        {
          console.log('Errorrr');
          swal(data.message, { button:false, icon: "error", timer: 1000});
        }
      },
      error: function(error) {
        var err = eval("(" + error.responseText + ")");
        var array_1 = $.map(err, function(value, index) {
            return [value];
        });
        var array_2 = $.map(array_1, function(value, index) {
            return [value];
        });
        var message = JSON.stringify(array_2);
        swal(message, { button:false, icon: "error", timer: 1000});
      }
    });
})    

});

</script>

@endpush