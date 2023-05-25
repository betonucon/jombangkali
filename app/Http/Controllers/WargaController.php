<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\WargaImport;
use Validator;
use PDF;
use App\Models\Warga;
use App\Models\Viewwarga;
use App\Models\Viewdatakk;
use App\Models\User;

class WargaController extends Controller
{
    
    public function index(request $request)
    {
        error_reporting(0);
        $template='top';
        if(Auth::user()->role_id==1){
            return view('warga.index_rw',compact('template'));
        }else{
            return view('warga.index',compact('template'));
        }
        
    }
    public function index_kk(request $request)
    {
        error_reporting(0);
        $template='top';
        if(Auth::user()->role_id==1){
            return view('warga.index_rw_kk',compact('template'));
        }else{
            return view('warga.index_kk',compact('template'));
        }
        
    }
    public function create(request $request)
    {
        error_reporting(0);
        $template='top';
        $id=$request->id;
        
        $data=Warga::where('id',$id)->first();
        if($id==0){
            $disabled='';
        }else{
            $disabled='readonly';
        }
        return view('warga.create',compact('template','data','disabled','id'));
    }
    public function modal(request $request)
    {
        error_reporting(0);
        $template='top';
        $data=Supplier::find($request->id);
        $id=$request->id;
        if($request->id==0){
            $disabled='';
        }else{
            $disabled='readonly';
        }
        return view('supplier.modal',compact('template','data','disabled','id'));
    }

    public function import(Request $request)
    {
        $rules = [
            'file'=> 'required|mimes:xlsx',
        ];

        $messages = [
            'file.required'=> 'Upload file excel',
            'file.mimes'=> 'Hanya menerima file .xlsx',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        $val=$validator->Errors();


        if ($validator->fails()) {
            echo'<div class="nitof"><b>Oops Error !</b><br><div class="isi-nitof">';
                foreach(parsing_validator($val) as $value){
                    
                    foreach($value as $isi){
                        echo'-&nbsp;'.$isi.'<br>';
                    }
                }
            echo'</div></div>';
        }else{
            $filess = $request->file('file');
            $nama_file = rand().$filess->getClientOriginalName();
            $filess->move('public/file_excel_warga',$nama_file);
            Excel::import(new WargaImport(), public_path('/file_excel_warga/'.$nama_file));
            echo '@ok';
        }
    }

    public function get_data(request $request)
    {
        error_reporting(0);
        $query = Viewwarga::query();
        // if($request->kd_divisi!=""){
        //     $data = $query->where('kd_divisi',$request->kd_divisi);
        // }
        if(Auth::user()->role_id==2){
            $data = $query->where('rt',Auth::user()->rt);
        }
        
        if($request->pernikahan==""){
            
        }else{
            $data = $query->whereIn('pernikahan',array($request->pernikahan));
        }
        if($request->pekerjaan==""){
            
        }else{
            $data = $query->whereIn('pekerjaan',array($request->pekerjaan));
        }
        if($request->aktif==""){
            $data = $query->whereIn('aktif',array(1,2,3));
        }else{
            $data = $query->whereIn('aktif',array($request->aktif));
        }
       
        $data = $query->orderBy('nama','Asc')->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('ttgl', function ($row) {
                $btn=$row->tempat_lahir.', '.$row->tanggal_lahir;
                return $btn;
            })
            ->addColumn('action', function ($row) {
                $btn='
                    <div class="btn-group">
                        <button type="button" class="btn btn-success btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                         <i class="fa fa-ellipsis-h"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:;" onclick="location.assign(`'.url('warga/create').'?id='.$row->id.'`)">Ubah</a></li>
                            <li><a href="javascript:;" onclick="delete_data('.$row->id.')">Delete</a></li>
                        </ul>
                    </div>
                ';
                return $btn;
            })
            
            ->rawColumns(['action'])
            ->make(true);
    }
    
    public function get_data_kk(request $request)
    {
        error_reporting(0);
        $query = Viewdatakk::query();
        
        $data = $query->where('cek',1)->orderBy('nama','Desc')->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('uang_nilai', function ($row) {
                $btn=uang($row->nilai);
                return $btn;
            })
            ->addColumn('action', function ($row) {
                $btn='
                    <div class="btn-group">
                        <button type="button" class="btn btn-success btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                         <i class="fa fa-ellipsis-h"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:;" onclick="window.open(`'.url('kk/cetak_warga').'?no_kk='.$row->no_kk.'`)">Cetak</a></li>
                        </ul>
                    </div>
                ';
                return $btn;
            })
            
            ->rawColumns(['action'])
            ->make(true);
    }
    public function delete_data(request $request){
        $data = Warga::where('id',$request->id)->update([
            'aktif'=>0,
        ]);

        echo'@ok';
    }

    
   
    public function store(request $request){
        error_reporting(0);
        $rules = [];
        $messages = [];
        if($request->id==0){
            $rules['nik']= 'required';
            $messages['nik.required']= 'Lengkapi kolom nik/no ktp';
            
           
        }
        
        $rules['no_kk']= 'required';
        $messages['no_kk.required']= 'Lengkapi kolom nomor kartu keluarga';
        $rules['nama']= 'required';
        $messages['nama.required']= 'Lengkapi kolom nama';
        
        $rules['tempat_lahir']= 'required';
        $messages['tempat_lahir.required']= 'Lengkapi kolom tempat lahir';

        $rules['tanggal_lahir']= 'required';
        $messages['tanggal_lahir.required']= 'Lengkapi kolom tanggal lahir';
        
        $rules['jenis_kelamin']= 'required';
        $messages['jenis_kelamin.required']= 'Lengkapi kolom jenis_kelamin';
        
        $rules['agama']= 'required';
        $messages['agama.required']= 'Lengkapi kolom agama';
        
        $rules['pekerjaan']= 'required';
        $messages['pekerjaan.required']= 'Lengkapi kolom pekerjaan';

        $rules['pernikahan']= 'required';
        $messages['pernikahan.required']= 'Lengkapi kolom pernikahan';

        $rules['pendidikan_id']= 'required';
        $messages['pendidikan_id.required']= 'Lengkapi kolom pendidikan';
        
        $rules['aktif']= 'required';
        $messages['aktif.required']= 'Lengkapi kolom status';
        
       
        $validator = Validator::make($request->all(), $rules, $messages);
        $val=$validator->Errors();


        if ($validator->fails()) {
            echo'<div class="nitof"><b>Oops Error !</b><br><div class="isi-nitof">';
                foreach(parsing_validator($val) as $value){
                    
                    foreach($value as $isi){
                        echo'-&nbsp;'.$isi.'<br>';
                    }
                }
            echo'</div></div>';
        }else{
            if($request->id==0){
               if($request->act==1){
                    $alamat=alamat().' RT/RW '.Auth::user()->rt.'/'.Auth::user()->rw.' '.kelurahan();
                    $status=1;
               }else{
                    $alamat=$request->alamat;
                    $status=2;
               }
               $cek=Warga::where('nik',$request->nik)->count();
               if($cek>0){
                echo'<div class="nitof"><b>Oops Error !</b><br><div class="isi-nitof">NIK Sudah Terdaftar</div></div>';
               }else{
                    $data=Warga::create([
                        
                        'nik'=>$request->nik,
                        'no_kk'=>$request->no_kk,
                        'nama'=>$request->nama,
                        'alamat'=>$alamat,
                        'jenis_kelamin'=>$request->jenis_kelamin,
                        'pendidikan_id'=>$request->pendidikan_id,
                        'tempat_lahir'=>$request->tempat_lahir,
                        'tanggal_lahir'=>$request->tanggal_lahir,
                        'agama'=>$request->agama,
                        'pekerjaan'=>$request->pekerjaan,
                        'pernikahan'=>$request->pernikahan,
                        'aktif'=>$request->aktif,
                        'status'=>$status,
                        'rt'=>Auth::user()->rt,
                        'rw'=>Auth::user()->rw,
                    ]);

                    echo'@ok';
               }
                
                
            }else{
                $data=Warga::where('id',$request->id)->update([
                        
                    'no_kk'=>$request->no_kk,
                    'nama'=>$request->nama,
                    'pendidikan_id'=>$request->pendidikan_id,
                    'jenis_kelamin'=>$request->jenis_kelamin,
                    'tempat_lahir'=>$request->tempat_lahir,
                    'tanggal_lahir'=>$request->tanggal_lahir,
                    'pernikahan'=>$request->pernikahan,
                    'agama'=>$request->agama,
                    'pekerjaan'=>$request->pekerjaan,
                    'aktif'=>$request->aktif,
                ]);

                echo'@ok';
            }
        }
    }

    public function cetak_kk(request $request){
        error_reporting(0);
        $id=decoder($request->id);
        if(Auth::user()->role_id==2){
            $data=Viewdatakk::where('cek',1)->where('rt',Auth::user()->rt)->get();
        }else{
            $data=Viewdatakk::where('cek',1)->get();
        }
        
        // $ford=3;
        $pdf = PDF::loadView('warga.cetak_kk', compact('data'));
        // $custom=array(0,0,500,400);
        $pdf->setPaper('A4','landscape');
        $pdf->stream('kartukeluarga.pdf');
        return $pdf->stream();
    }
    public function cetak_warga(request $request){
        error_reporting(0);
        $id=decoder($request->id);
        if(Auth::user()->role_id==2){
            $data=Viewdatakk::where('cek',1)->where('no_kk',$request->no_kk)->where('rt',Auth::user()->rt)->get();
        }else{
            $data=Viewdatakk::where('cek',1)->get();
        }
        
        // $ford=3;
        $pdf = PDF::loadView('warga.cetak_warga', compact('data'));
        // $custom=array(0,0,500,400);
        $pdf->setPaper('A4','landscape');
        $pdf->stream('kartukeluarga.pdf');
        return $pdf->stream();
    }
}
