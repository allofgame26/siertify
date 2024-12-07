@extends('layouts.template')
@section('content')
@if (Auth::user()->getRole() == 'ADM')
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">

            {{-- sertif belum disetujui --}}
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>150</h3>

                        <p>Sertifikasi Belum Disetujui</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>53<sup style="font-size: 20px"></sup></h3>

                        <p>Sertifikasi Telah Disetujui</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>44</h3>

                        <p>Pelatihan Belum Disetujui</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-indigo">
                    <div class="inner">
                        <h3>65</h3>

                        <p>Pelatihan Disetujui</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <section class="col-lg-5 connectedSortable">
                <!-- Custom tabs (Charts with tabs)-->
                <div class="card">
                    <div class="card-header bg-info">
                        <h3 class="card-title">
                          Persentase Sertifikasi dan Pelatihan Dosen
                        </h3>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <canvas id="pieChart" style="min-height: 250px; height: 300px; max-height:300px; max-width: 100%;"></canvas>
                      </div>
                </div>
                <!-- /.card -->
            </section>
            <!-- right col -->
            <section class="col-lg-7 connectedSortable">
              <!-- Custom tabs (Charts with tabs)-->
              <div class="card">
                  <div class="card-header bg-info">
                      <h3 class="card-title">
                        10 Bidang Minat Terbanyak
                      </h3>
                  </div><!-- /.card-header -->
                  <div class="card-body">
                      <div class="tab-content p-0">
                          <!-- Morris chart - Sales -->
                          <div class="chart tab-pane active" id="revenue-chart"
                              style="position: relative; height: 300px;">
                              <div class="card-body">
                                <div class="chart">
                                  <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                              </div>
                          </div>
                          <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
                              <canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>
                          </div>
                      </div>
                  </div><!-- /.card-body -->
              </div>
              <!-- /.card -->
          </section>
        </div>
        <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
@endif

@if (Auth::user()->getRole() == 'SDM')
<div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">

        {{-- sertif belum disetujui --}}
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>4</h3>

                    <p>Jenis Pengguna</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>90<sup style="font-size: 20px"></sup></h3>

                    <p>Data Dosen</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>95</h3>

                    <p>Akun Pengguna</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
    <!-- /.row -->
    <!-- Main row -->
    <div class="row">
        <!-- Left col -->
        <section class="col-lg-5 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">
                      Persentase Sertifikasi dan Pelatihan Dosen
                    </h3>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <canvas id="pieChart" style="min-height: 250px; height: 300px; max-height:300px; max-width: 100%;"></canvas>
                  </div>
            </div>
            <!-- /.card -->
        </section>
        <!-- right col -->
        <section class="col-lg-7 connectedSortable">
          <!-- Custom tabs (Charts with tabs)-->
          <div class="card">
              <div class="card-header bg-info">
                  <h3 class="card-title">
                    10 Bidang Minat Terbanyak
                  </h3>
              </div><!-- /.card-header -->
              <div class="card-body">
                  <div class="tab-content p-0">
                      <!-- Morris chart - Sales -->
                      <div class="chart tab-pane active" id="revenue-chart"
                          style="position: relative; height: 300px;">
                          <div class="card-body">
                            <div class="chart">
                              <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                          </div>
                      </div>
                      <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
                          <canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>
                      </div>
                  </div>
              </div><!-- /.card-body -->
          </div>
          <!-- /.card -->
      </section>
    </div>
    <!-- /.row (main row) -->
</div><!-- /.container-fluid -->
@endif

@endsection

@push('js')



<!-- jQuery -->
<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('adminlte/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

<!-- AdminLTE App -->
<script src="{{ asset('adminlte/dist/js/adminlte.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('adminlte/dist/js/pages/dashboard.js') }}"></script>

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('adminlte/plugins/chart.js/Chart.min.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('adminlte/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('adminlte/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('adminlte/plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/jqvmap/maps/jquery.vmap.world.js') }}"></script>

<script>
   $(document).ready(function () {
    // PIE CHART
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
    var pieData = {
        labels: ['Pelatihan', 'Sertifikasi'],
        datasets: [{
            data: [53, 150],
            backgroundColor: ['#3C8DBC', '#605CA8']
        }]
    };
    var pieOptions = {
        maintainAspectRatio: false,
        responsive: true,
    };
    new Chart(pieChartCanvas, {
        type: 'pie',
        data: pieData,
        options: pieOptions
    });

 // Bar Chart
 var barChartCanvas = $('#barChart').get(0).getContext('2d');
        
        var barChartData = {
            labels: [
                'Algoritma Evolusioner',
                'Analisis Data',
                'Aplikasi Permainan',
                'Artificial Intelligence',
                'Attention Based RNN',
                'Augmented Reality (AR)',
                'Big Data',
                'Clustering',
                'Cognitive Artificial Intelligence',
                'Data Analysis'
            ],
            datasets: [{
                label: 'Jumlah Dosen',
                data: [12, 15, 8, 20, 5, 7, 18, 10, 9, 14],
                backgroundColor: [
                    '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', 
                    '#FF9F40', '#E7E9ED', '#FF5733', '#C70039', '#900C3F'
                ]
            }]
        };

        var barChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        };

        new Chart(barChartCanvas, {
            type: 'bar',
            data: barChartData,
            options: barChartOptions
        });
    });


</script>

@endpush
