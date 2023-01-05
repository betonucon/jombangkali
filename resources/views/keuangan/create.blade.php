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

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Form Pengisian Keuangan
        
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
          <h3 class="box-title"></h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        
        <div class="box-body">
          <form  id="mydata" class="form-horizontal" method="post" action="{{ url('keuangan') }}" enctype="multipart/form-data" >
            @csrf 
            <input type="hidden" name="id" value="{{$id}}">
            <div class="row">
            
              <div class="col-md-12">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Keterangan</label>

                  <div class="col-sm-7">
                    <input type="text" class="form-control" name="keterangan" value="{{$data->keterangan}}" placeholder="Keterangan / sumber uang">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Status </label>

                  <div class="col-sm-3">
                    <select  name="status_keuangan_id" class="form-control  input-sm">
                      <option value="">All Data</option>
                      @foreach(get_statuskeuangancari() as $agm)
                        <option value="{{$agm->id}}"  >{{$agm->status_keuangan}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Nilai</label>

                  <div class="col-sm-3">
                    <input type="number" class="form-control"  name="nilai"  value="{{$data->nilai}}"  placeholder="nilai">
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Tanggal </label>
                  <div class="col-sm-3">
                    <div class="input-group date">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control pull-right" name="tanggal" id="tanggal_lahir"  value="{{$data->tanggal}}"  placeholder="yyyy-mm-dd">
                    </div>
                  </div>
                  
                </div>
                
              </div>
              
            </div>
          </form>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <div class="btn-group">
            <button type="button" class="btn btn-danger" onclick="location.assign(`{{url('keuangan')}}`)">Kembali</button>
            <button type="button" class="btn btn-info" id="simpan_data"><i class="fa fa-save"></i> Simpan</button>
          </div>
        </div>
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
@endsection

@push('ajax')
    <script>
      $('#tanggal_lahir').datepicker({
        autoclose: true,
        format:"yyyy-mm-dd"
      })
      
      $('#simpan_data').on('click', () => {
            
            var form=document.getElementById('mydata');
                $.ajax({
                    type: 'POST',
                    url: "{{ url('keuangan') }}?act=1",
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
                            
                            swal("Success! berhasil disimpan!", {
									            icon: "success",
                            });
                            location.assign(`{{url('keuangan')}}`);
                                
                        }else{
                          document.getElementById("loadnya").style.width = "0px";
                                swal({
                                    title: 'Notifikasi',
                                
                                    html:true,
                                    text:'ss',
                                    icon: 'error',
                                    buttons: {
                                        cancel: {
                                            text: 'Tutup',
                                            value: null,
                                            visible: true,
                                            className: 'btn btn-dangers',
                                            closeModal: true,
                                        },
                                        
                                    }
                                });
                                $('.swal-text').html('<div style="width:100%;background:#f2f2f5;padding:1%;text-align:left;font-size:13px">'+msg+'</div>')
                        }
                        
                        
                    }
                });
        });
    </script>
@endpush
