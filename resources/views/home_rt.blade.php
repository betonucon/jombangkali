@extends('layouts.app')

@push('style')
  <style>
    label {
        display: inline-block;
        max-width: 100%;
        margin-bottom: 5px;
        font-weight: normal;
    }
  </style>
@endpush
@push('datatable')
<script type="text/javascript">
        /*
        Template Name: Color Admin - Responsive Admin Dashboard Template build with Twitter Bootstrap 4
        Version: 4.6.0
        Author: Sean Ngu
        Website: http://www.seantheme.com/color-admin/admin/
        */
        
        var handleDataTableFixedHeader = function() {
            "use strict";
            
            if ($('#data-table-fixed-header').length !== 0) {
                var table=$('#data-table-fixed-header').DataTable({
                    lengthMenu: [20,50,100],
                    fixedHeader: {
                        header: true,
                        headerOffset: $('#header').height()
                    },
                    responsive: true,
                    ajax:"{{ url('barang/getdata')}}",
                      columns: [
                        { data: 'KD_Barang', render: function (data, type, row, meta) 
                            {
                              return meta.row + meta.settings._iDisplayStart + 1;
                            } 
                        },
                        
                        { data: 'action' },
                        { data: 'KD_Barang' },
                        { data: 'Kd_JenisBarang' },
                        { data: 'Nama_Barang' },
                        { data: 'uang_Harga_Beli' },
                        
                      ],
                      
                });
            }
        };

        var TableManageFixedHeader = function () {
            "use strict";
            return {
                //main function
                init: function () {
                    handleDataTableFixedHeader();
                }
            };
        }();

        $(document).ready(function() {
			TableManageFixedHeader.init();
            
		});

        
    </script>
@endpush
@section('content')
<div class="content-wrapper" style="min-height: 926.281px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control Transaksi</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    
    <section class="content">
      
    <div class="row">
            <div class="col-md-3">
            <div class="row">
                <div class="col-md-12">
                    <div class="info-box bg-yellow">
                        <span class="info-box-icon"><i class="fa fa-users"></i></span>

                        <div class="info-box-content">
                        <span class="info-box-text">Laki-Laki</span>
                        <span class="info-box-number" style="font-size: 14.3px;">{{count_jeniskelamin_rt('L')}}</span>
                        <span class="info-box-text">Perempuan</span>
                        <span class="info-box-number" style="font-size: 14.3px;">{{count_jeniskelamin_rt('P')}}</span>

                        
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>
                <div class="col-md-6">

                </div>
                </div>
            </div>
            @foreach(get_statusaktif() as $agm)
                <div class="col-md-3">
                    <div class="info-box" style="background: #fff;">
                    <span class="info-box-icon bg-{{$agm->color}}"><i class="ion ion-ios-people-outline"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">{{$agm->status_aktif}}</span>
                        <span class="info-box-number">{{count_aktif_rt($agm->id)}}</span>
                    </div>
                    </div>
                </div>
            @endforeach
    </div>
        
        
      
      <div class="row">
        <div class="col-md-8">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Grafik Keuangan RT {{Auth::user()->rt}} Tahun {{$tahun}}</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="chart">
                        <canvas id="barChart" style="height: 230px; width: 510px;" height="230" width="510"></canvas>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Dashboard Pernikahan</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        @foreach(get_pernikahan() as $agm)
                            <div class="col-md-4">
                                <div class="info-box bg-{{$agm->color}}">
                                    <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">{{$agm->pernikahan}}</span>
                                        <span class="info-box-number">{{count_pernikahan_rt($agm->pernikahan)}}</span>

                                        <div class="progress">
                                            <div class="progress-bar" style="width: {{persen_pernikahan_rt($agm->pernikahan)}}%"></div>
                                        </div>
                                        <span class="progress-description">
                                            {{persen_pernikahan_rt($agm->pernikahan)}}%
                                        </span>
                                    </div>
                                    
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Dashboard Pekerjaan</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                       <div class="col-md-12">
                            @foreach(get_pekerjaan() as $agm)
                           
                 
                                <div class="clearfix">
                                    <span class="pull-left">{{$agm->pekerjaan}} ({{count_pekerjaan_rt($agm->pekerjaan)}})</span>
                                    <small class="pull-right">{{persen_pekerjaan_rt($agm->pekerjaan)}}%</small>
                                </div>
                                <div class="progress xs">
                                    <div class="progress-bar progress-bar-{{$agm->color}}" style="width: {{persen_pekerjaan_rt($agm->pekerjaan)}}%;"></div>
                                </div>

                
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="col-md-4">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">KEUANGAN {{$tahun}}</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>Bulan</th>
                                    <th>Pemasukan</th>
                                    <th >Pengeluaran</th>
                                </tr>
                                @for($x=1;$x<13;$x++)
                                    <tr>
                                        <td>{{bulan(ubah_bulan($x))}}</td>
                                        <td>{{uang(sum_keuangan_periode(2,ubah_bulan($x),$tahun))}}</td>
                                        <td>{{uang(sum_keuangan_periode(3,ubah_bulan($x),$tahun))}}</td>
                                    </tr>
                                    
                                @endfor
                                
                            
                            </tbody>
                    
                        </table>
                    </div>
                </div>
                  
            </div>
                 
                
        </div>
      </div>
      
    </section>
  </div>
@endsection

@push('ajax')
<script src="{{url_plug()}}/bower_components/chart.js/Chart.js"></script>
<!-- FastClick -->
<!-- page script -->
<script>
  $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    

    var areaChartData = {
      labels  : [
        @for($x=1;$x<13;$x++)
            '{{bulan(ubah_bulan($x))}}',
        @endfor
      ],
      datasets: [
        @foreach(get_statuskeuangancari() as $agm)
            {
            label               : '{{$agm->status_keuangan}}',
            fillColor           : 'rgba(210, 214, 222, 1)',
            strokeColor         : 'rgba(210, 214, 222, 1)',
            pointColor          : 'rgba(210, 214, 222, 1)',
            pointStrokeColor    : '#c1c7d1',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(220,220,220,1)',
            data                : [
                @for($x=1;$x<13;$x++)
                    {{sum_keuangan_periode($agm->id,ubah_bulan($x),$tahun)}},
                @endfor
            ]
            //   sum_keuangan_periode
            },
        @endforeach
      ]
    }
    // get_CustomerYear
    
   
   
    var barChartCanvas                   = $('#barChart').get(0).getContext('2d')
    var barChart                         = new Chart(barChartCanvas)
    var barChartData                     = areaChartData
    barChartData.datasets[1].fillColor   = '#00a65a'
    barChartData.datasets[1].strokeColor = '#00a65a'
    barChartData.datasets[1].pointColor  = '#00a65a'
   
   
    

    var barChartOptions                  = {
      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero        : true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines      : true,
      //String - Colour of the grid lines
      scaleGridLineColor      : 'rgba(0,0,0,.05)',
      //Number - Width of the grid lines
      scaleGridLineWidth      : 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines  : true,
      //Boolean - If there is a stroke on each bar
      barShowStroke           : true,
      //Number - Pixel width of the bar stroke
      barStrokeWidth          : 2,
      //Number - Spacing between each of the X value sets
      barValueSpacing         : 5,
      //Number - Spacing between data sets within X values
      barDatasetSpacing       : 1,
      //String - A legend template
      legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
      //Boolean - whether to make the chart responsive
      responsive              : true,
      maintainAspectRatio     : true
    }

    barChartOptions.datasetFill = false
    barChart.Bar(barChartData, barChartOptions)
    barChartcustomer.Bar(barChartDatacustomer, barChartOptions)
  })
</script>      
@endpush
