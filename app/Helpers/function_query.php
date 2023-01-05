<?php

function get_rt(){
    $data=App\Models\Mrt::get();
    return $data;
}
function get_agama(){
    $data=App\Models\Magama::get();
    return $data;
}
function get_statuskeuangan(){
    $data=App\Models\Mstatuskeuangan::orderBy('id','Asc')->get();
    return $data;
}
function get_statuskeuangancari(){
    $data=App\Models\Mstatuskeuangan::whereIn('id',array(2,3))->orderBy('id','Asc')->get();
    return $data;
}
function sum_keuangan($status_keuangan_id){
    if($status_keuangan_id==1){
        if(Auth::user()->role_id==4 || Auth::user()->role_id==2){
            $masuk =App\Models\Keuangan::where('rt',Auth::user()->rt)->where('status_keuangan_id',2)->where('aktif',1)->sum('nilai');
            $keluar =App\Models\Keuangan::where('rt',Auth::user()->rt)->where('status_keuangan_id',3)->where('aktif',1)->sum('nilai');
        }
        if(Auth::user()->role_id==3 || Auth::user()->role_id==1){
            $masuk = App\Models\Keuangan::where('rw',Auth::user()->rw)->whereIn('role_id',array(1,3))->where('status_keuangan_id',2)->where('aktif',1)->sum('nilai');
            $keluar = App\Models\Keuangan::where('rw',Auth::user()->rw)->whereIn('role_id',array(1,3))->where('status_keuangan_id',3)->where('aktif',1)->sum('nilai');
        }
        $data=$masuk-$keluar;
    }else{
        if(Auth::user()->role_id==4 || Auth::user()->role_id==2){
            $data =App\Models\Keuangan::where('rt',Auth::user()->rt)->where('status_keuangan_id',$status_keuangan_id)->where('aktif',1)->sum('nilai');
        }
        if(Auth::user()->role_id==3 || Auth::user()->role_id==1){
            $data = App\Models\Keuangan::where('rw',Auth::user()->rw)->whereIn('role_id',array(1,3))->where('status_keuangan_id',$status_keuangan_id)->where('aktif',1)->sum('nilai');
        }
    }
    return $data;
}
function sum_keuangan_periode($status_keuangan_id,$bulan,$tahun){
    if(Auth::user()->role_id==4 || Auth::user()->role_id==2){
        $data =App\Models\Keuangan::where('rt',Auth::user()->rt)->where('status_keuangan_id',$status_keuangan_id)->whereMonth('tanggal',$bulan)->whereYear('tanggal',$tahun)->where('aktif',1)->sum('nilai');
    }
    if(Auth::user()->role_id==3 || Auth::user()->role_id==1){
        $data = App\Models\Keuangan::where('rw',Auth::user()->rw)->whereIn('role_id',array(1,3))->where('status_keuangan_id',$status_keuangan_id)->whereMonth('tanggal',$bulan)->whereYear('tanggal',$tahun)->where('aktif',1)->sum('nilai');
    }
    return $data;
}
function get_statusaktif(){
    $data=App\Models\Mstatusaktif::get();
    return $data;
}
function get_pernikahan(){
    $data=App\Models\Mpernikahan::get();
    return $data;
}
function count_pernikahan_rt($pernikahan){
    $data=App\Models\Viewwarga::where('pernikahan',$pernikahan)->where('rt',Auth::user()->rt)->count();
    return $data;
}
function persen_pernikahan_rt($pernikahan){
    $all=App\Models\Viewwarga::where('rt',Auth::user()->rt)->count();
    $data=App\Models\Viewwarga::where('pernikahan',$pernikahan)->where('rt',Auth::user()->rt)->count();
    return round(($data/$all)*100);
}
function count_pekerjaan_rt($pekerjaan){
    $data=App\Models\Viewwarga::where('pekerjaan',$pekerjaan)->where('rt',Auth::user()->rt)->count();
    return $data;
}
function persen_pekerjaan_rt($pekerjaan){
    $all=App\Models\Viewwarga::where('rt',Auth::user()->rt)->count();
    $data=App\Models\Viewwarga::where('pekerjaan',$pekerjaan)->where('rt',Auth::user()->rt)->count();
    return round(($data/$all)*100);
}
function count_aktif_rt($aktif){
    $data=App\Models\Viewwarga::where('aktif',$aktif)->where('rt',Auth::user()->rt)->count();
    return $data;
}
function persen_aktif_rt($aktif){
    $all=App\Models\Viewwarga::where('rt',Auth::user()->rt)->count();
    $data=App\Models\Viewwarga::where('aktif',$aktif)->where('rt',Auth::user()->rt)->count();
    return round(($data/$all)*100);
}
function count_jeniskelamin_rt($jeniskelamin){
    $data=App\Models\Viewwarga::where('jenis_kelamin',$jeniskelamin)->where('rt',Auth::user()->rt)->count();
    return $data;
}
function count_jeniskelamin($jeniskelamin){
    $data=App\Models\Viewwarga::where('jenis_kelamin',$jeniskelamin)->count();
    return $data;
}

function count_pernikahan($pernikahan){
    $data=App\Models\Viewwarga::where('pernikahan',$pernikahan)->count();
    return $data;
}
function persen_pernikahan($pernikahan){
    $all=App\Models\Viewwarga::count();
    $data=App\Models\Viewwarga::where('pernikahan',$pernikahan)->count();
    return round(($data/$all)*100);
}
function count_pekerjaan($pekerjaan){
    $data=App\Models\Viewwarga::where('pekerjaan',$pekerjaan)->count();
    return $data;
}
function persen_pekerjaan($pekerjaan){
    $all=App\Models\Viewwarga::count();
    $data=App\Models\Viewwarga::where('pekerjaan',$pekerjaan)->count();
    return round(($data/$all)*100);
}
function count_aktif($aktif){
    $data=App\Models\Viewwarga::where('aktif',$aktif)->count();
    return $data;
}
function persen_aktif($aktif){
    $all=App\Models\Viewwarga::count();
    $data=App\Models\Viewwarga::where('aktif',$aktif)->count();
    return round(($data/$all)*100);
}

function get_pendidikan(){
    $data=App\Models\Mpendidikan::orderBy('id','Asc')->get();
    return $data;
}
function get_pekerjaan(){
    $data=App\Models\Mpekerjaan::get();
    return $data;
}
function get_warga(){
    $data=App\Models\Warga::get();
    return $data;
}
function count_warga($rt,$act){
    $data=App\Models\Warga::where('rt',$rt)->count();
    return $data;
}

?>