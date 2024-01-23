<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi PDF</title>
    <style>
        /* @font-face { font-family: 'Gotham Bold'; font-style: normal; font-weight:
    normal; src: url('{{ url('fonts/GothamBold.ttf') }}'); } */
        /*
    @import('https://www.dafontfree.net/embed/Z290aGFtLWJvbGQmZGF0YS8yNS9nLzEyNzUxNi9Hb3RoYW1Cb2xkLnR0Zg'); */
        body {
            font-family: Helvetica !important;
            padding-bottom: 30px;
            font-size: 11pt;
            margin: 0px 1px 100px 1px;
        }
        .tth{
            border:solid 1px #000;
            background:aqua;
            font-weight:bold;
        }
        .ttd{
            border:solid 1px #000;
            padding-left:4px;
        }
        .ttd-right{
            border:solid 1px #000;
            padding-left:4px;
            padding-right:4px;
            text-align:right
        }
        #header {
            position: fixed;
            top: 0;
            width: 100%;
        }
        .tbl{
            border-collapse:collapse;
        }
        #header #pagenumber {
            float: right;
            color: #666;
            margin-right: 20px;
        }

        #header #pagenumber:after {
            content: counter(page);
        }

        #main-wrapper {
            /* page-break-before: always; */
            margin-right: 20px;
            height:920px;
        }

        /* #recipients{
    width:100%; } #recipients div{ width: 50%; border: 1px solid #c00; } */
        .tac {
            text-align: center;
        }

        .full-width {
            width: 100%
        }

        .u {
            text-decoration: underline;
        }

        .mb-0 {
            margin-bottom: 0;
        }
        
        footer {
            width: 100%;
            height:100px;
            position: fixed;
            left: 0;
            background:#fff;
            bottom: -30px;
        }

        footer * {
            
            font-size: 9px;
            
        }

        .left-footer {
            position: absolute;
            bottom: 20px;
            
        }

        .kan-wrapper {
            position: absolute;
            bottom: 0;
            right: 0;
            margin-right: 50px;
            margin-bottom: 10px;
        }
        .ck-content .table table, figure.table table {
            /* width: 107% !important; */
            width: 100% !important;
            margin-left: -2.7em;
            margin-right: -2.7em;
            word-break: break-word;
            word-wrap: break-word;
            /* table-layout: fixed; */
            border-collapse: collapse;
            border-spacing: 0;
        }

        figure.table table tr th, figure.table table tr td {
            border: 1px solid black;
            padding: 2px;
        }
        
        .pin-wrapper {
            position: absolute;
            bottom: 0;
            top: 0;
            right: 0;
            transform: translate(50%, 50%);
            transform-origin: center right;
        }

        @page {
            margin-top: 30px;
           
            margin-right: 0;
        }

        #sign ol {
            padding-left: 20px;
            padding-top: 0;
            margin: 0
        }

        .vat {
            vertical-align: top;
            text-transform:capitalize;
        }
    </style>
   
</head>

<body>
    <!-- HEADER -->
    <div id="header">
        
        <div class="pin-wrapper">
            <img src="{{ public_path('img/blue.jpg') }}" height="150" width="30" />
            
        </div>
    </div>

    <footer>
        
       
        <div class="left-footer">
            <br><br>
             <u>Dokumen ini diterbitkan secara elektronik menggunakan aplikasi administrasi RW 001 jombang kali untuk kepentingan lingkungan RT 001 RW 001</u>
        </div>

        <div class="kan-wrapper">
            
        </div>

    </footer>


    <br>
    @foreach(get_periode_laporan($tahun) as $mst)
    <div id="main-wrapper">
        <h2 class="tac  mb-0" style="margin-top: -10px"><b>LAPORAN KEUANGAN</b></h2>
        <h3 class="tac  mb-0" style="margin-top: 2px"><b>RT.001 RW.001</b></h3>
        
        <p class="tac" style="margin-top:0">TAHUN {{$mst->tahun}}</p>
        <br>
        
        
        <table class="full-width" style="margin-left: -2.5px;">
            <tr>
                <td class="vat" width="15%">Perihal</td>
                <td class="vat" width="3%">:</td>
                <td class="vat">Laporan Keuangan </td>
            </tr>
            <tr>
                <td class="vat">Periode</td>
                <td class="vat">:</td>
                
                <td class="vat">{{bulan(ubah_bulan($mst->bulan))}} {{$mst->tahun}}</td>
            </tr>
        </table>
        <hr style="margin-bottom: -10px;">
        <br>
            <table width="100%"  class="tbl">
                <tr>
                    <th class="tth" width="6%">NO</th>
                    <th class="tth" width="12%">Tanggal</th>
                    <th class="tth">Keterangan</th>
                    <th class="tth" width="15%">Debit</th>
                    <th class="tth" width="15%">Kredit</th>
                </tr>
                <?php
                    $no=2;
                ?>
                <tr>
                    <td class="ttd">1</td>
                    <td class="ttd">{{$mst->tahun}}-{{ubah_bulan($mst->bulan)}}-01</td>
                    <td class="ttd">Sisa Saldo</td>
                   
                    <td class="ttd-right">0</td>
                    <td class="ttd-right">{{uang($mst->total_masuk-$mst->total_keluar)}}</td>
                   
                </tr>
                @foreach(get_keuangan(ubah_bulan($mst->bulan),$mst->tahun) as $o)
                <tr>
                    <td class="ttd">{{$no++}}</td>
                    <td class="ttd">{{$o->tanggal}}</td>
                    <td class="ttd">{{$o->keterangan}}</td>
                    @if($o->status_keuangan_id==2)
                    <td class="ttd-right">0</td>
                    <td class="ttd-right">{{uang($o->nilai)}}</td>
                    @else
                    <td class="ttd-right">{{uang($o->nilai)}}</td>
                    <td class="ttd-right">0</td>
                    @endif
                </tr>
                @endforeach
                <tr>
                    <th class="ttd-right" colspan="3">TOTAL</th>
                    <th class="ttd-right">{{uang(total_keuangan(ubah_bulan($mst->bulan),$tahun,3))}}</th>
                    <th class="ttd-right">{{uang(total_keuangan(ubah_bulan($mst->bulan),$tahun,2)+($mst->total_masuk-$mst->total_keluar))}}</th>
                </tr>
                <tr>
                    <th class="ttd-right" colspan="3">SISA SALDO</th>
                    <th class="ttd-right"></th>
                    <th class="ttd-right">{{uang((total_keuangan(ubah_bulan($mst->bulan),$tahun,2)+($mst->total_masuk-$mst->total_keluar))-total_keuangan(ubah_bulan($mst->bulan),$tahun,3))}}</th>
                </tr>
            </table>
        <br>
        
    </div>
    @endforeach
</body>

</html>