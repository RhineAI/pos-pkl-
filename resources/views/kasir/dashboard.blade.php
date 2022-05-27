@extends('layouts.main')

@section('title')
Dashboard
@endsection

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 p-2 mb-3" style="background-color: white">
        @if(session()->has('alert'))
        <div class="alert alert-success text-white mr-2 mb-2 ml-2 ml-2" id="alert"><i class="fa fa-circle-check"></i>
            &nbsp; {{ session()->get('alert') }}
        </div>
        @endif
        <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <!-- .col -->
                <div class="col-lg-6 col-12">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $seluruh_penjualan }}</h3>
    
                            <p>Total Penjualan</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <!-- .col -->
                <div class="col-lg-6 col-12">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>Rp. {{ format_uang($data_pemasukkan) }}</h3>
    
                            <p>Total Pendapatan</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-money-bill"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->
            <!-- Main row -->
        </div><!-- /.container-fluid -->
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-md-12">
                        <div class="card card-success">
                          <div class="card-header">
                            <h3 class="card-title">Grafik Penjualan {{ tanggal_indonesia($TanggalAwal, false) }} s/d {{ tanggal_indonesia($TanggalAkhir, false) }}</h3>
            
                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                              </button>
                              <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                              </button>
                            </div>
                          </div>
                          <div class="card-body">
                            <div class="chart">
                              <canvas id="areaChart2" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                          </div>
                          <!-- /.card-body -->
                        </div>
                      </div>
                  </div>
                </div>
              </section>
              <!-- /.content -->
    </div>
</div>
@endsection

@push('scripts')
<!-- ChartJS -->
<script src="{{ asset('AdminLTE-master/plugins/chart.js/Chart.min.js') }}"></script>
    <script>
        $(function () {
            //--------------
            //- AREA CHART -
            //--------------

            // Get context with jQuery - using jQuery's .get() method.
            var areaChartCanvas2 = $('#areaChart2').get(0).getContext('2d')

            var areaChartData2 = {
                labels: {{ json_encode($data_tanggal) }},
                datasets: [{
                        label: 'Digital Goods',
                        backgroundColor: 'rgb(10, 143, 32)',
                        borderColor: 'rgb(10, 143, 32)',
                        pointRadius: false,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(60,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: {{ json_encode($data_pendapatan) }}
                    },
                ]
            }

            var areaChartOptions2 = {
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false,
                        }
                    }],
                    yAxes: [{
                        gridLines: {
                            display: false,
                        }
                    }]
                }
            }

            // This will get the first returned node in the jQuery collection.
            new Chart(areaChartCanvas2, {
                type: 'line',
                data: areaChartData2,
                options: areaChartOptions2
            })

            var time = document.getElementById("alert");
            
            setTimeout(function(){
                time.style.display = "none";
            }, 3000);
        })
    </script>
@endpush