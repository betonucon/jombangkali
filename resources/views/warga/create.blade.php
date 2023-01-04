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
        Form Pengisian Warga Tetap
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Barang</li>
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
          <form  id="mydata" class="form-horizontal" method="post" action="{{ url('warga') }}" enctype="multipart/form-data" >
            @csrf 
            <input type="hidden" name="id" value="{{$id}}">
            <div class="row">
            
              <div class="col-md-6">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Nama</label>

                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="nama" value="{{$data->nama}}" placeholder="Nama warga">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">NIK/No KTP</label>

                  <div class="col-sm-7">
                    <input type="text" class="form-control" {{$disabled}} name="nik"  value="{{$data->nik}}"  placeholder="3673***********************">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">NO KK </label>

                  <div class="col-sm-7">
                    <input type="text" class="form-control" name="no_kk"  value="{{$data->no_kk}}"  placeholder="3673***********************">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Tempat Tgl Lahir </label>

                  <div class="col-sm-5">
                    <input type="text" class="form-control" name="tempat_lahir"  value="{{$data->tempat_lahir}}"  placeholder="serang">
                  </div>
                  <div class="col-sm-4">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right" name="tanggal_lahir" id="tanggal_lahir"  value="{{$data->tanggal_lahir}}"  placeholder="yyyy-mm-dd">
                    </div>
                    
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Jenis Kelamin </label>

                  <div class="col-sm-7">
                    <div class="radio">
                      <label>
                        <input type="radio" name="jenis_kelamin" @if($data->jenis_kelamin=='L') checked @endif id="jenis_kelamin1" value="L" checked="">
                        Laki-laki
                      </label>
                      <label>
                        <input type="radio" name="jenis_kelamin"  @if($data->jenis_kelamin=='P') checked @endif  id="jenis_kelamin1" value="P" checked="">
                        Perempuan
                      </label>
                    </div>
                  </div>
                </div>
                
              </div>
              <div class="col-md-6">
                
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Agama </label>

                  <div class="col-sm-6">
                    <select class="form-control" name="agama"  >
                        <option value="">Pilih-----</option>
                        @foreach(get_agama() as $agm)
                          <option value="{{$agm->agama}}"  @if($data->agama==$agm->agama) selected @endif >{{$agm->agama}}</option>
                        @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Pendidikan </label>

                  <div class="col-sm-3">
                    <select class="form-control" name="pendidikan_id"  >
                        <option value="">Pilih-----</option>
                        @foreach(get_pendidikan()() as $agm)
                          <option value="{{$agm->id}}" @if($data->pendidikan_id==$agm->id) selected @endif >{{$agm->pendidikan}}</option>
                        @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Pernikahan </label>

                  <div class="col-sm-5">
                    <select class="form-control" name="pernikahan"  >
                        <option value="">Pilih-----</option>
                        @foreach(get_pernikahan() as $agm)
                          <option value="{{$agm->pernikahan}}"  @if($data->pernikahan==$agm->pernikahan) selected @endif >{{$agm->pernikahan}}</option>
                        @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Pekerjaan </label>

                  <div class="col-sm-6">
                    <select class="form-control" name="pekerjaan"  >
                        <option value="">Pilih-----</option>
                        @foreach(get_pekerjaan() as $agm)
                          <option value="{{$agm->pekerjaan}}"  @if($data->pekerjaan==$agm->pekerjaan) selected @endif >{{$agm->pekerjaan}}</option>
                        @endforeach
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Status </label>

                  <div class="col-sm-3">
                    <select class="form-control" name="aktif"  >
                        <option value="">Pilih-----</option>
                        @foreach(get_statusaktif() as $agm)
                          <option value="{{$agm->id}}" @if($data->aktif==$agm->id) selected @endif >{{$agm->status_aktif}}</option>
                        @endforeach
                    </select>
                  </div>
                </div>
                
              </div>
              
            </div>
          </form>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <div class="btn-group">
            <button type="button" class="btn btn-danger" onclick="location.assign(`{{url('warga')}}`)">Kembali</button>
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
                    url: "{{ url('warga') }}?act=1",
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
                            location.assign(`{{url('warga')}}`);
                                
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
