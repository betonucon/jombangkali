<?php

namespace App\Imports;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use App\Models\Warga;

class WargaImport implements ToModel, WithStartRow,WithCalculatedFormulas
{
    
    public function collection(Collection $collection)
    {
        //
    }

    public function model(array $row)
    {
        error_reporting(0);
       
            return Warga::UpdateOrcreate(
                [
                    'nik'=>$row[1],
                    'no_kk'=>$row[2],
                ],
                [
                    'nama'=>$row[3],
                    'rt'=>Auth::user()->rt,
                    'rw'=>Auth::user()->rw,
                    'jenis_kelamin'=>$row[4],
                    'tempat_lahir'=>$row[5],
                    'tanggal_lahir'=>$row[6],
                    'pekerjaan'=>$row[7],
                    'aktif'=>1,
                ],
            );
        
        
            
        
    }

    public function startRow(): int
    {
        return 4;
    }
}
