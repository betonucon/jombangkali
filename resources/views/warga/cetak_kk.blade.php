<html>
    <head>
        <title>DAFTAR WARGA</title>
        <style>
            html{
                font-family:sans-serif;
            }
            .header{
                height:70px;
                border:solid 1px #fff;
                width:98%;
                padding:1%;
            }
            .spasi{
                height:5px;
                border:solid 1px #fff;
                width:98%;
                padding:1%;
            }
            .body{
                height:540px;
                border:solid 1px #fff;
                width:100%;
                
            }
            .td_head{
                font-size:13px;
                font-weight:bold;
                text-transform:uppercase;
            }
            .th{
                font-size:12px;
                padding:5px;
                font-weight:bold;
                border:solid 1px #000;
                text-transform:uppercase;
            }
            .td{
                font-size:12px;
                padding:5px;
                border:solid 1px #000;
                text-transform:uppercase;
            }
        </style>
    </head>
    <body>
        @foreach($data as $o)
            <div class="header">
                <table width="100%">
                    <tr>
                        <td class="td_head" width="20%">NO KARTU KELUARGA</td>
                        <td class="td_head" width="3%">:</td>
                        <td class="td_head">{{$o->no_kk}}</td>
                    </tr>
                    <tr>
                        <td class="td_head">KEPALA KELUARGA</td>
                        <td class="td_head">:</td>
                        <td class="td_head">{{$o->nama}}</td>
                    </tr>
                    <tr>
                        <td class="td_head">ALAMAT</td>
                        <td class="td_head">:</td>
                        <td class="td_head">Link Jombang Kali RT:001 RW:001</td>
                    </tr>
                </table>
            </div>
            <div class="spasi">

            </div>
            <div class="body">
                 <table width="100%" style="border-collapse:collapse">
                    <tr>
                        <td class="th" width="5%">NO</td>
                        <td class="th" width="15%">NIK</td>
                        <td class="th" >NAMA</td>
                        <td class="th" width="15%">TANGGAL LAHIR</td>
                        <td class="th" width="5%">P/L</td>
                        <td class="th" width="15%">PEKERJAAN</td>
                        <td class="th" width="15%">PENDIDIKAN</td>
                    </tr>
                    @foreach(get_detail_warga($o->no_kk) as $no=>$xs)
                    <tr>
                        <td class="td">{{$no+1}}</td>
                        <td class="td">{{$xs->nik}}</td>
                        <td class="td">{{$xs->nama}}</td>
                        <td class="td">{{indo_tanggal($xs->tanggal_lahir)}}</td>
                        <td class="td">{{$xs->jenis_kelamin}}</td>
                        <td class="td">{{$xs->pekerjaan}}</td>
                        <td class="td">{{$xs->pendidikan}}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        @endforeach
    </body>
</html>