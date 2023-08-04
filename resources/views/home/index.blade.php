@extends('master')
 
@section('title', 'Dashboard')

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
        <h4>INFOGRAFIS</h4>
    </div>
    <div class="card-body">

    <div class="row">

        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4> Total Paket Bulan {{ date('M') }} </h4>
                    </div>
                    <div class="card-body">
                        <div id="loadingSpinner_total_package" class="loadSpinner">
                            <img src="{{ asset('layout/assets/img/loading-animation-ajax.gif') }}" alt="Loading..." style="width: 50px; hight:50px">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="fas fa-male"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4> Customer Terbanyak TF Bulan {{ date('M') }} </h4>
                    </div>
                    <div class="card-body">
                        <div id="loadingSpinner_best_customer" class="loadSpinner">
                            <img src="{{ asset('layout/assets/img/loading-animation-ajax.gif') }}" alt="Loading..." style="width: 50px; hight:50px">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="fas fa-male"></i>
                </div>
                <div class="card-wrap">
                <div class="card-header">
                    <h4> Total Customer Baru Pada Bulan {{ date('M') }} </h4>
                </div>
                <div class="card-body">
                    <div id="loadingSpinner_new_customer" class="loadSpinner">
                        <img src="{{ asset('layout/assets/img/loading-animation-ajax.gif') }}" alt="Loading..." style="width: 50px; hight:50px">
                    </div>
                </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                <i class="fas fa-print"></i>
                </div>
                <div class="card-wrap">
                <div class="card-header">
                    <h4> Jumlah Pesanan Belum Tercetak </h4>
                </div>
                <div class="card-body">
                    <div id="loadingSpinner_not_printed" class="loadSpinner">
                        <img src="{{ asset('layout/assets/img/loading-animation-ajax.gif') }}" alt="Loading..." style="width: 50px; hight:50px">
                    </div>
                </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="card-wrap">
                <div class="card-header">
                    <h4> Pendapatan Bulan {{ date('M') }} </h4>
                </div>
                <div class="card-body">
                    <div id="loadingSpinner_income" class="loadSpinner">
                        <img src="{{ asset('layout/assets/img/loading-animation-ajax.gif') }}" alt="Loading..." style="width: 50px; hight:50px">
                    </div>
                </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="card-wrap">
                <div class="card-header">
                    <h4> Pengeluaran Bulan {{ date('M') }} </h4>
                </div>
                <div class="card-body">
                    <div id="loadingSpinner_expense" class="loadSpinner">
                        <img src="{{ asset('layout/assets/img/loading-animation-ajax.gif') }}" alt="Loading..." style="width: 50px; hight:50px">
                    </div>
                </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="card-wrap">
                <div class="card-header">
                    <h4> Pendapatan Sementara Bulan {{ date('M') }} </h4>
                </div>
                <div class="card-body">
                    <div id="loadingSpinner_temporary_income" class="loadSpinner">
                        <img src="{{ asset('layout/assets/img/loading-animation-ajax.gif') }}" alt="Loading..." style="width: 50px; hight:50px">
                    </div>
                </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-6 col-12 col-md">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="card-wrap">
                <div class="card-header">
                    <h4> Transaksi Hari ini <small> vs Kemarin </small> </h4>
                </div>
                <div class="card-body">
                    <div id="loadingSpinner_temporary_income" class="loadSpinner">
                        <img src="{{ asset('layout/assets/img/loading-animation-ajax.gif') }}" alt="Loading..." style="width: 50px; hight:50px">
                    </div>
                </div>
                </div>
            </div>
        </div>
        
    </div>

    <div class="row">
        <div class="col-6">            
            <canvas id="traffic_sale_offline" width="400" height="200"></canvas>
        </div>
        
        <div class="col-6">
            <canvas id="traffic_sale_shopee" width="400" height="200"></canvas>
        </div>
    </div>
        
    </div>

    </div>
</div>
</div>


@endsection

@push('scripts')

<script type="text/javascript">

    var ctx = document.getElementById('traffic_sale_offline').getContext('2d');
    var cty = document.getElementById('traffic_sale_shopee').getContext('2d');
    
    $(function() {

        $('.loadSpinner').show();
                
        $.ajax({
            type:'POST',
            url: '{{route("dashboard-transaction")}}',
            data:
            {
                "_token": "{{ csrf_token() }}",
            },
            beforeSend: function() {
               
            },
            success: function(data) {
                $('#loadingSpinner_total_package').html(data.package_total);
                $('#loadingSpinner_best_customer').html(data.best_cutomer);
                $('#loadingSpinner_not_printed').html(data.not_printed);
            },
            error: function() {

            }
        });

        $.ajax({
            type:'POST',
            url: '{{route("dashboard-customer")}}',
            data:
            {
                "_token": "{{ csrf_token() }}",
            },
            success:function(data) {
                $('#loadingSpinner_new_customer').html(data.new_customer);            
            }
        });

        $.ajax({
            type:'POST',
            url: '{{route("dashboard-salesOfflineChart")}}',
            data:
            {
                "_token": "{{ csrf_token() }}",
            },
            success:function(data) {
                console.log(data);
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.label,
                        datasets: [{
                            label: 'Penjualan Harian Non Shopee',
                            data:data.dataseet,
                            borderColor: 'rgb(75, 192, 192)',
                            tension: 0.1
                        }]
                    }
                });         
            }
        });


        $.ajax({
            type:'POST',
            url: '{{route("dashboard-salesOnlineChart")}}',
            data:
            {
                "_token": "{{ csrf_token() }}",
            },
            success:function(data) {
                console.log(data);
                new Chart(cty, {
                    type: 'line',
                    data: {
                        labels: data.label,
                        datasets: [{
                            label: 'Penjualan Harian Shopee',
                            data:data.dataseet,
                            borderColor: 'rgb(75, 192, 192)',
                            tension: 0.1
                        }]
                    }
                });         
            }
        });



        $.ajax({
            type:'POST',
            url: '{{route("dashboard-cashflow")}}',
            data:
            {
                "_token": "{{ csrf_token() }}",
            },
            success:function(data) {
                $('#loadingSpinner_income').html(data.income);
                $('#loadingSpinner_expense').html(data.expense);
                $('#loadingSpinner_temporary_income').html(data.income - data.expense);            
            }
        });

    });
   

</script>


@endpush