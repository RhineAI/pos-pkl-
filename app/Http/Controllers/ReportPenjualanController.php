<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\Pengeluaran;
use App\Models\Penjualan;
use Barryvdh\DomPDF\Pdf;
use Illuminate\Http\Request;


class ReportPenjualanController extends Controller
{
    public function index(Request $request)
    {
        $tanggalAwal = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
        $tanggalAkhir = date('Y-m-d');

        if ($request->has('tanggal_awal') && $request->tanggal_awal != "" && $request->has('tanggal_akhir') && $request->tanggal_akhir) {
            $tanggalAwal = date('Y-m-d', strtotime($request->tanggal_awal));
            $tanggalAkhir = date('Y-m-d', strtotime($request->tanggal_akhir));
            
            
        }

        return view('reportpenjualan.index', compact('tanggalAwal', 'tanggalAkhir'));
    }

    public function getData($awal, $akhir)
    {
        $no = 1;
        $data = array();

        while (strtotime($awal) <= strtotime($akhir)) {
            $tanggal = $awal;
            $awal = date('Y-m-d', strtotime("+1day", strtotime($awal)));

            $total_penjualan = Penjualan::where('created_at', 'LIKE', "%$tanggal%")->sum('bayar');
            
            // $penjualan = Penjualan::where('created_at', 'LIKE', "%$tanggal%")->sum('bayar');
            $penjualan = Penjualan::first();
            
            $row = array();
             $row['DT_RowIndex'] = $no++;
            $row['tanggal'] = tanggal_indonesia($tanggal, false);
            // $row['nota'] = 'INV-202005'. $penjualan->kode_penjualan ;
            $row['penjualan'] = 'Rp. '.format_uang($total_penjualan);
            // $row['aksi']        = '<div class="btn-group">
            //                         <button onclick="{{ route(`daftarpenjualan.index`) }}" class="btn btn-xs btn-info btn-flat"><i class="fa fa-eye"></i> Detail</button>
            //                     </div>';

            $data[] = $row;
        }

        $data[] = [
            'DT_RowIndex' => '',
            'tanggal' => '',
            'nota' => '',
            'penjualan' => '',
            'aksi' => '',
        ];

        return $data;
    }

    public function data($awal, $akhir)
    {
        $data = $this->getData($awal, $akhir);

        return datatables()
            ->of($data)
            ->rawColumns(['aksi'])
            ->make(true);
    }

    // public function data($awal, $akhir)
    // {
    //     $data = $this->getData($awal, $akhir);

    //     return datatables()
    //         ->of($data)
    //         ->make(true);
    // }

    public function exportPDF($awal, $akhir)
    {
        $data = $this->getData($awal, $akhir);
        $pdf  = Pdf::loadView('reportpenjualan.pdf', compact('awal', 'akhir', 'data'));
        $pdf->setPaper('a4', 'potrait');
        
        return $pdf->stream('Laporan-pendapatan-'. date('Y-m-d-his') .'.pdf');
    }
}