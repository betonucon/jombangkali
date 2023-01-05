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
                    lengthMenu: [50],
                    searching:true,
                    lengthChange:false,
                    ordering:false,
                    fixedHeader: {
                        header: true,
                        headerOffset: $('#header').height()
                    },
                    dom: 'lrtip',
                    responsive: true,
                    ajax:"{{ url('keuangan/getdata')}}",
                      columns: [
                        { data: 'id', render: function (data, type, row, meta) 
                            {
                              return meta.row + meta.settings._iDisplayStart + 1;
                            } 
                        },
                        
                        { data: 'action' },
                        { data: 'keterangan' },
                        { data: 'tanggal' },
                        { data: 'uang_nilai' },
                        { data: 'status_keuangan' },
                        
                        
                      ],
                      
                });
                $('#cari_datatable').keyup(function(){
                  table.search($(this).val()).draw() ;
                })

                
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

        
        function pilih_jenis(status_keuangan_id){
          var tables=$('#data-table-fixed-header').DataTable();
          tables.ajax.url("{{ url('keuangan/getdata')}}?status_keuangan_id="+status_keuangan_id).load();
          tables.on( 'draw', function () {
              var count=tables.data().count();
                $('#count_data').html('Total data :'+count)  
          } );
              
        }
        

        $(document).ready(function() {
          TableManageFixedHeader.init();
               
        });

        
    </script>
@endpush
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Daftar Keuangan RT {{Auth::user()->rt}}
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Keuangan</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        
        <div class="box-header with-border">
          <div class="row">
              
              @foreach(get_statuskeuangan() as $agm)
                <div class="col-md-4">
                  <div class="info-box" style="background: #f3ebeb;">
                    <span class="info-box-icon bg-{{$agm->color}}"><i class="fa fa-money"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text"><b>{{$agm->status_keuangan}}</b></span>
                      <span class="info-box-number">{{uang(sum_keuangan($agm->id))}}</span>
                    </div>
                  </div>
                </div>
              @endforeach
              
          </div>
        </div>
        <div class="box-header with-border">
          <div class="row">
            <div class="col-md-7">
              
              <div class="form-group">
                  <label></label>
                  <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-primary" onclick="tambah(0)"><i class="fa fa-plus"></i> Tambah data</button>
                    <button type="button" class="btn btn-sm btn-info" onclick="location.assign(`{{url('keuangan')}}`)"><i class="fa fa-refresh"></i> Refresh</button>
                  </div>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>Status Keuangan</label>
                  <select onchange="pilih_jenis(this.value)" id="status_keuangan_id" class="form-control  input-sm">
                    <option value="">All Data</option>
                    @foreach(get_statuskeuangancari() as $agm)
                      <option value="{{$agm->id}}"  >{{$agm->status_keuangan}}</option>
                    @endforeach
                  </select>
               
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                  <label>Cari data</label>
                  <input type="text" id="cari_datatable" placeholder="Search....." class="form-control input-sm">
                  
              </div>
            </div>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
           
            <div class="col-md-12">
              <div class="table-responsive">
                <table id="data-table-fixed-header" width="100%" class="cell-border">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            
                            <th width="4%"></th>
                            <th>Keterangan </th>
                            <th width="11%">Tanggal</th>
                            <th width="15%">Nilai</th>
                            <th width="15%">Status</th>
                            
                            
                        </tr>
                    </thead>
                    
                </table>
              </div>
            </div>
            
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          
        </div>
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>

  <div class="modal fade" id="modal-import" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Upload Data Warga</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger m-b-0" id="notifikasiimport">
                    <div id="notifikasi-import"></div>
                    
                </div>
                <form  id="mydataimport" method="post" action="{{ url('warga/import') }}" enctype="multipart/form-data" >
                    @csrf 
                    <input type="submit">
                    <div class="form-group">
                        <label>Upload File Excel</label>
                        <input type="file" name="file" class="form-control" />
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <a href="javascript:;" class="btn btn-white" data-dismiss="modal">Tutup</a>
                <a href="javascript:;" class="btn btn-danger" id="import-data" >Proses</a>
            </div>
        </div>
    </div>
  </div> 
   
@endsection

@push('ajax')
    <script>
      $('#notifikasiimport').hide();

      function tambah(id){
        location.assign("{{url('keuangan/create')}}?id="+id)
      }

      function delete_data(id){
           
           swal({
             title: "Yakin menghapus data ini ?",
             text: "data akan hilang dari daftar ini",
             type: "warning",
             icon: "error",
             showCancelButton: true,
             align:"center",
             confirmButtonClass: "btn-danger",
             confirmButtonText: "Yes, delete it!",
             closeOnConfirm: false
           }).then((willDelete) => {
             if (willDelete) {
                 $.ajax({
                   type: 'GET',
                   url: "{{url('keuangan/delete_data')}}",
                   data: "id="+id,
                   success: function(msg){
                     swal("Success! berhasil terhapus!", {
                       icon: "success",
                     });
                     var table=$('#data-table-fixed-header').DataTable();
                          table.ajax.url("{{ url('keuangan/getdata')}}").load();
                   }
                 });
               
               
             } else {
               
             }
           });
           
      }

      $('#import-data').on('click', () => {
            
            var form=document.getElementById('mydataimport');
                $.ajax({
                    type: 'POST',
                    url: "{{ url('warga/import') }}",
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend: function() {
                        document.getElementById("loadnya").style.width = "100%";
                    },
                    success: function(msg){
                        var bat=msg.split('@');
                        if(bat[1]=='ok'){
                            $('#modal-import').modal('hide');
                            document.getElementById("loadnya").style.width = "0px";
                            swal("Success! berhasil diimport!", {
									            icon: "success",
                            });
                            var table=$('#data-table-fixed-header').DataTable();
                            table.ajax.url("{{ url('warga/getdata')}}").load();
                                
                        }else{
                            document.getElementById("loadnya").style.width = "0px";
                            $('#notifikasiimport').show();
                            $('#notifikasi-import').html(msg);
                        }
                        
                        
                    }
                });
        });
    </script>
@endpush
