<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\WargaImport;
use Validator;
use App\Models\Keuangan;
use App\Models\Viewkeuangan;
use App\Models\User;

class KeuanganController extends Controller
{
    
    public function index(request $request)
    {
        error_reporting(0);
        $template='top';
        if(Auth::user()->role_id==1){
            return view('keuangan.index_rw',compact('template'));
        }else{
            return view('keuangan.index',compact('template'));
        }
        
    }
    public function create(request $request)
    {
        error_reporting(0);
        $template='top';
        $id=$request->id;
        
        $data=Keuangan::where('id',$id)->first();
        if($id==0){
            $disabled='';
        }else{
            $disabled='readonly';
        }
        return view('keuangan.create',compact('template','data','disabled','id'));
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
        $query = Viewkeuangan::query();
        // if($request->kd_divisi!=""){
        //     $data = $query->where('kd_divisi',$request->kd_divisi);
        // }
        if(Auth::user()->role_id==4){
            $data = $query->where('rt',Auth::user()->rt);
        }
        if(Auth::user()->role_id==3){
            $data = $query->where('rw',Auth::user()->rw);
        }
        
        if($request->status_keuangan_id==""){
            
        }else{
            $data = $query->whereIn('status_keuangan_id',array($request->status_keuangan_id));
        }
        
        $data = $query->where('aktif',1)->orderBy('tanggal','Desc')->get();

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
                            <li><a href="javascript:;" onclick="location.assign(`'.url('keuangan/create').'?id='.$row->id.'`)">Ubah</a></li>
                            <li><a href="javascript:;" onclick="delete_data('.$row->id.')">Delete</a></li>
                        </ul>
                    </div>
                ';
                return $btn;
            })
            
            ->rawColumns(['action'])
            ->make(true);
    }
    

    public function delete_data(request $request){
        $data = Keuangan::where('id',$request->id)->update([
            'aktif'=>0,
        ]);

        echo'@ok';
    }

    
   
    public function store(request $request){
        error_reporting(0);
        $rules = [];
        $messages = [];
        if($request->id==0){
            $rules['keterangan']= 'required';
            $messages['keterangan.required']= 'Lengkapi kolom keterangan';
            
           
        }
        
        $rules['status_keuangan_id']= 'required';
        $messages['status_keuangan_id.required']= 'Lengkapi kolom status keuangan';

        $rules['nilai']= 'required|numeric';
        $messages['nilai.required']= 'Lengkapi kolom nilai';
        
        $rules['tanggal']= 'required';
        $messages['tanggal.required']= 'Lengkapi kolom tanggal';

        
       
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
               
                    $data=Keuangan::create([
                        
                        'keterangan'=>$request->keterangan,
                        'nilai'=>$request->nilai,
                        'tanggal'=>$request->tanggal,
                        'status_keuangan_id'=>$request->status_keuangan_id,
                        'rt'=>Auth::user()->rt,
                        'rw'=>Auth::user()->rw,
                        'aktif'=>1,
                        'role_id'=>Auth::user()->role_id,
                        'created'=>date('Y-m-d H:i:s'),
                    ]);

                    echo'@ok';
                
                
            }else{
                $data=Keuangan::where('id',$request->id)->update([
                        
                    'keterangan'=>$request->keterangan,
                    'nilai'=>$request->nilai,
                    'tanggal'=>$request->tanggal,
                    'status_keuangan_id'=>$request->status_keuangan_id,
                ]);

                echo'@ok';
            }
        }
    }
}
