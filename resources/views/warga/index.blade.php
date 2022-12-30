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
                    ajax:"{{ url('warga/getdata')}}",
                      columns: [
                        { data: 'id', render: function (data, type, row, meta) 
                            {
                              return meta.row + meta.settings._iDisplayStart + 1;
                            } 
                        },
                        
                        { data: 'action' },
                        { data: 'nik' },
                        { data: 'no_kk' },
                        { data: 'nama' },
                        { data: 'ttgl' },
                        { data: 'jenis_kelamin' },
                        { data: 'umur' },
                        { data: 'pekerjaan' },
                        { data: 'status_aktif' },
                   
                        
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

        function pilih_pernikahan(pernikahan){
          var tables=$('#data-table-fixed-header').DataTable();
          var pekerjaan=$('#pekerjaan').val();
          var aktif=$('#aktif').val();
          tables.ajax.url("{{ url('warga/getdata')}}?aktif="+aktif+"&pekerjaan="+pekerjaan+"&pernikahan="+pernikahan).load();
          tables.on( 'draw', function () {
              var count=tables.data().count();
                $('#count_data').html('Total data :'+count)  
          } );
              
        }
        function pilih_jenis(aktif){
          var tables=$('#data-table-fixed-header').DataTable();
          var pekerjaan=$('#pekerjaan').val();
          var pernikahan=$('#pernikahan').val();
          tables.ajax.url("{{ url('warga/getdata')}}?aktif="+aktif+"&pekerjaan="+pekerjaan+"&pernikahan="+pernikahan).load();
          tables.on( 'draw', function () {
              var count=tables.data().count();
                $('#count_data').html('Total data :'+count)  
          } );
              
        }
        function pilih_pekerjaan(pekerjaan){
          var tables=$('#data-table-fixed-header').DataTable();
          var aktif=$('#aktif').val();
          var pernikahan=$('#pernikahan').val();
          tables.ajax.url("{{ url('warga/getdata')}}?aktif="+aktif+"&pekerjaan="+pekerjaan+"&pernikahan="+pernikahan).load();
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
        Daftar Warga RT {{Auth::user()->rt}}
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Warga</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        
        <div class="box-header with-border">
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
                  <div class="info-box" style="background: #f3ebeb;">
                    <span class="info-box-icon bg-{{$agm->color}}"><i class="ion ion-ios-people-outline"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">{{$agm->status_aktif}}</span>
                      <span class="info-box-number">{{count_aktif_rt($agm->id)}}</span>
                    </div>
                  </div>
                </div>
              @endforeach
                <div class="col-md-12">
                    @foreach(get_pernikahan() as $agm)

                    @endforeach
                </div>
          </div>
        </div>
        <div class="box-header with-border">
          <div class="row">
            <div class="col-md-3">
              
              <div class="form-group">
                  <label></label>
                  <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-primary" onclick="tambah(0)"><i class="fa fa-plus"></i> Tambah data</button>
                    <button type="button" class="btn btn-sm btn-success" onclick="$('#modal-import').modal('show')"><i class="fa fa-save"></i> Import</button>
                    <button type="button" class="btn btn-sm btn-info" onclick="location.assign(`{{url('warga')}}`)"><i class="fa fa-refresh"></i> Refresh</button>
                  </div>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>Status Pernikahan</label>
                  <select onchange="pilih_pernikahan(this.value)" id="pernikahan" class="form-control  input-sm">
                    <option value="">All Data</option>
                    @foreach(get_pernikahan() as $agm)
                      <option value="{{$agm->pernikahan}}"  >{{$agm->pernikahan}}</option>
                    @endforeach
                  </select>
               
              </div>

            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>Status Pekerjaan</label>
                  <select onchange="pilih_pekerjaan(this.value)" id="pekerjaan" class="form-control  input-sm">
                    <option value="">All Data</option>
                    @foreach(get_pekerjaan() as $agm)
                      <option value="{{$agm->pekerjaan}}"  >{{$agm->pekerjaan}}</option>
                    @endforeach
                  </select>
               
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>Status Warga</label>
                  <select onchange="pilih_jenis(this.value)" id="aktif" class="form-control  input-sm">
                    <option value="">All Data</option>
                    @foreach(get_statusaktif() as $agm)
                      <option value="{{$agm->id}}"  >{{$agm->status_aktif}}</option>
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
                <table id="data-table-fixed-header" class="cell-border">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            
                            <th width="4%"></th>
                            <th width="12%">NIK</th>
                            <th width="14%">NO Kartu Keluarga</th>
                            <th>Nama </th>
                            <th width="13%">TTGL</th>
                            <th width="7%">Umur</th>
                            <th width="9%">J.K</th>
                            <th width="9%">Pekerjaan</th>
                            <th width="9%">Status</th>
                            
                            
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
        location.assign("{{url('warga/create')}}?id="+id)
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
                   url: "{{url('warga/delete_data')}}",
                   data: "id="+id,
                   success: function(msg){
                     swal("Success! berhasil terhapus!", {
                       icon: "success",
                     });
                     var table=$('#data-table-fixed-header').DataTable();
                          table.ajax.url("{{ url('warga/getdata')}}").load();
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
