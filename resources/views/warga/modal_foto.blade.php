
    <div class="form-group row">
        <label for="inputEmail3" class="col-sm-3 control-label">Warga </label>
        <div class="col-sm-4">
            <input type="text" readonly class="form-control" name="nik" id="nik"  value="{{$data->nik}}"  placeholder="yyyy-mm-dd">
        </div>
        <div class="col-sm-5">
            <input type="text" readonly class="form-control" name="nama" id="nama"  value="{{$data->nama}}"  placeholder="yyyy-mm-dd">
        </div>
    </div>
    <div class="form-group row">
        <label for="inputEmail3" class="col-sm-3 control-label">Foto KTP </label>
        <div class="col-sm-9">
            <div class="input-group date">
                <div class="input-group-addon">
                <i class="fa fa-file-image-o"></i>
                </div>
                <input type="file" class="form-control pull-right" name="foto" id="foto"  value="{{$data->tanggal_lahir}}"  placeholder="yyyy-mm-dd">
            </div>
        
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-12">
            @if($data->ktp!="")
                <img src="{{url_plug()}}/_ktp/{{$data->ktp}}" width="100%" height="200px">
            @endif
        
        </div>
    </div>
