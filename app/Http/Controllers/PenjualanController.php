<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Setting;
use Barryvdh\DomPDF\PDF;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('daftarpenjualan.index');
    }


    function checkPrice($value)
    {
        if (gettype($value) == "string") {
            $temp = 0;
            for ($i = 0; $i < strlen($value); $i++) {
                if ((isset($value[$i]) == true && $value[$i] != ".") && $value[$i] != ",") {
                    $temp = ($temp * 10) + (int)$value[$i];
                }
            }
            return $temp;
        } else {
            return $value;
        }
    }


    public function data() 
    {
        $penjualan = Penjualan::orderBy('id_penjualan', 'desc')->get();

        return datatables()
            ->of($penjualan)
            ->addIndexColumn()
            ->addColumn('total_item', function($penjualan) {
                return format_uang($penjualan->total_item) . ' qty';
            })
            ->addColumn('tanggal', function($penjualan) {
                return tanggal_indonesia($penjualan->created_at, false);
            })
            ->addColumn('total_harga', function($penjualan) {
                return 'Rp. ' . format_uang($penjualan->total_harga) . ' ,-';
            })
            ->addColumn('diskon', function($penjualan) {
                return $penjualan->diskon . ' %';
            })
            ->addColumn('bayar', function($penjualan) {
                return 'Rp. ' . format_uang($penjualan->bayar) . ' ,-';
            })
            ->addColumn('kasir', function($penjualan) {
                return $penjualan->user->name ?? '';
            })
            ->addColumn('aksi', function ($penjualan) {
                return '
                    <button onclick="showDetail(`'. route('daftarpenjualan.show', $penjualan->id_penjualan) .'`)" class="btn btn-xs btn-info delete"><i class="bi bi-eye-fill"></i></button>
                    <button onclick="deleteData(`'. route('daftarpenjualan.destroy', $penjualan->id_penjualan) .'`)" class="btn btn-xs btn-danger delete"><i class="bi bi-trash"></i></button>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $penjualan = new Penjualan();
        $produk = Penjualan::select('kode_penjualan')->orderBy('created_at', 'DESC')->first();
        
        $kode = $penjualan->id_penjualan+3;

        // if($produk == NULL) {
        //     $kode = '202205001';
        // } else {
        //     $kode = sprintf('202205%03d', substr($produk->barcode, 10) + 1);
        //     // $kode = sprintf('BRC-202205%03d' + 1);
        // }

        // $request['barcode'] = $kode;

        // $request['kode_penjualan'] = $kode;
        $penjualan->kode_penjualan = $kode;
        $penjualan->total_item = 0;
        $penjualan->total_harga = 0;
        $penjualan->diskon = 0;
        $penjualan->bayar = 0;
        $penjualan->diterima = 0;
        $penjualan->id_user = auth()->id();
        $penjualan->save();

        session(['id_penjualan' => $penjualan->id_penjualan]);
        return redirect()->route('transaksi.index');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $penjualan = Penjualan::findOrFail($request->id_penjualan);
        $penjualan->total_item = $request->total_item;
        $penjualan->total_harga = $request->total;
        $penjualan->diskon = $request->diskon;
        $penjualan->bayar = $request->bayar;
        $penjualan->diterima = $this->checkPrice($request->diterima);
        $penjualan->update();

        $detail = PenjualanDetail::Where('id_penjualan', $penjualan->id_penjualan)->get();
        foreach ($detail as $item) {
            $produk = Produk::find($item->id_produk);
            $produk->stok -= $item->jumlah;
            $produk->update();
        }

        $cancel = $penjualan;

        $cancel2 = $detail;

        return redirect('/transaksi/done');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $penjualan = PenjualanDetail::with('produk')->where('id_penjualan', $id)->get();

        return datatables()
            ->of($penjualan)
            ->addIndexColumn()
            ->addColumn('barcode', function($penjualan) {
                return '<span class="badge badge-info">'. $penjualan->produk->barcode .'</span>';
            })
            ->addColumn('nama_produk', function($penjualan) {
                return $penjualan->produk->nama_produk;
            })
            ->addColumn('harga_jual', function($penjualan) {
                return 'Rp. ' . format_uang($penjualan->harga_jual) . ' ,-';
            })
            ->addColumn('jumlah', function($penjualan) {
                return format_uang($penjualan->jumlah) . ' qty';
            })
            ->addColumn('subtotal', function($penjualan) {
                return 'Rp. ' . format_uang($penjualan->subtotal) . ' ,-';
            })
            ->rawColumns(['aksi', 'barcode'])
            ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $penjualan = Penjualan::find($id);
        $detail    = PenjualanDetail::where('id_penjualan', $penjualan->id_penjualan)->get();
        foreach ($detail as $item) {
            $produk = Produk::find($item->id_produk);
            if ($produk) {
                $produk->stok += $item->jumlah;
                $produk->update();
            }

            $item->delete();
        }

        $penjualan->delete();

        return response(null, 204);
    }


    public function done() {
        $setting = Setting::first();
        $produk = Produk::first();

        $penjualan = Penjualan::find(session('id_penjualan')); 
        $penjualan->diterima = $this->checkPrice(format_uang($penjualan->diterima)); 
        if (! $penjualan) 
        {
            abort(404);
        }
        $detail = PenjualanDetail::with('produk')->where('id_penjualan', session('id_penjualan'))->get();

        
        return view('transaksi.done', compact('setting' , 'penjualan', 'detail', 'produk'));
    }

    public function cancel($id) {
        $penjualan = Penjualan::find($id);

        $detail    = PenjualanDetail::where('id_penjualan', $penjualan->id_penjualan)->get();
        foreach ($detail as $item) {
            $produk = Produk::find($item->id_produk);
            if ($produk) {
                $produk->stok += $item->jumlah;
                $produk->update();
            }

            $item->delete();
        }

        $penjualan->delete();

        // alert('{{ alert }}');

        return redirect('/dashboard')->with('alert', 'Transaksi dibatalkan');

    }

    public function notaKecil() 
    {
        $setting = Setting::first();
        $produk = Produk::first();
        $penjualan = Penjualan::find(session('id_penjualan'));
        if (! $penjualan) 
        {
            abort(404);
        }

        $detail = PenjualanDetail::with('produk')->where('id_penjualan', session('id_penjualan'))->get();

        return view('daftarpenjualan.nota_kecil', compact('setting', 'penjualan', 'detail', 'produk'));
    }

    public function notaBesar()
    {
        $setting = Setting::first();
        $penjualan = Penjualan::find(session('id_penjualan'));
        if (! $penjualan) {
            abort(404);
        }
        $detail = PenjualanDetail::with('produk')
            ->where('id_penjualan', session('id_penjualan'))
            ->get();

        $pdf = PDF::loadView('penjualan.nota_besar', compact('setting', 'penjualan', 'detail'));
        $pdf->setPaper(0,0,609,440, 'potrait');
        return $pdf->stream('Transaksi-'. date('Y-m-d-his') .'.pdf');
    }
}
