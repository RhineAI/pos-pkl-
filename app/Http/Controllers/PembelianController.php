<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembelian;
use App\Models\PembelianDetail;
use App\Models\Produk;
use App\Models\StokMasuk;
use App\Models\Supplier;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $supplier = Supplier::orderBy('id_supplier', 'desc')->get();
        // $stokMasuk= StokMasuk::orderBy('id_stok_masuk', 'desc')->get();

        return view('pembelian.index',compact('supplier', // 'stokMasuk' 
        ));
    }

    

    
    public function data() {
        $pembelian = Pembelian::orderBy('id_pembelian', 'desc')->get();

        return datatables()
            ->of($pembelian)
            ->addIndexColumn()
            ->addColumn('total_item', function($pembelian) {
                return format_uang($pembelian->total_item) . ' qty';
            })
            ->addColumn('tanggal', function($pembelian) {
                return tanggal_indonesia($pembelian->created_at, false);
            })
            ->addColumn('supplier', function($pembelian) {
                return $pembelian->supplier->nama;
            })
            ->addColumn('total_harga', function($pembelian) {
                return 'Rp. ' . format_uang($pembelian->total_harga) . ' ,-';
            })
            ->addColumn('diskon', function($pembelian) {
                return $pembelian->diskon . ' %';
            })
            ->addColumn('bayar', function($pembelian) {
                return 'Rp. ' . format_uang($pembelian->bayar) . ' ,-';
            })
            ->addColumn('aksi', function ($pembelian) {
                return '
                    <button onclick="showDetail(`'. route('pembelian.show', $pembelian->id_pembelian) .'`)" class="btn btn-xs btn-info delete"><i class="bi bi-eye-fill"></i></button>
                    <button onclick="deleteData(`'. route('pembelian.destroy', $pembelian->id_pembelian) .'`)" class="btn btn-xs btn-danger delete"><i class="bi bi-trash"></i></button>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }



    public function cancel($id) {
        $pembelian = Pembelian::find($id);

        $detail    = PembelianDetail::where('id_pembelian', $pembelian->id_pembelian)->get();
        foreach ($detail as $item) {
            $produk = Produk::find($item->id_produk);
            if ($produk) {
                $produk->stok -= $item->jumlah;
                $produk->update();
            }

            $item->delete();
        }

        $pembelian->delete();

        return redirect('/dashboard');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $pembelian = new Pembelian();
        $pembelian->kode_pembelian = 0;
        $pembelian->id_supplier = $id;
        $pembelian->total_item  = 0;
        $pembelian->total_harga = 0;
        $pembelian->diskon      = 0;
        $pembelian->bayar = 0;
        $pembelian->save();

        session(['id_pembelian'=> $pembelian->id_pembelian]);
        session(['id_supplier'=> $pembelian->id_supplier]);

        return redirect()->route('pembelian_detail.index');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pembelian = Pembelian::findOrFail($request->id_pembelian);
        $pembelian->total_item = $request->total_item;
        $pembelian->total_harga = $request->total;
        $pembelian->diskon = $request->diskon;
        $pembelian->bayar = $request->bayar;
        $pembelian->update();

        $detail = PembelianDetail::Where('id_pembelian', $pembelian->id_pembelian)->get();
        foreach ($detail as $item) {
            $produk = Produk::find($item->id_produk);
            $produk->stok += $item->jumlah;
            $produk->update();
        }

        return redirect()->route('pembelian.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $detail = PembelianDetail::with('produk')->where('id_pembelian', $id)->get();

        return datatables()
            ->of($detail)
            ->addIndexColumn()
            ->addColumn('barcode', function($detail) {
                return '<span class="badge badge-info">'. $detail->produk->barcode .'</span>';
            })
            ->addColumn('nama_produk', function($detail) {
                return $detail->produk->nama_produk;
            })
            ->addColumn('harga_beli', function($detail) {
                return 'Rp. ' . format_uang($detail->harga_beli) . ' ,-';
            })
            ->addColumn('jumlah', function($detail) {
                return format_uang($detail->jumlah) . ' qty';
            })
            ->addColumn('subtotal', function($detail) {
                return 'Rp. ' . format_uang($detail->subtotal) . ' ,-';
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
        $pembelian = Pembelian::find($id);
        $detail    = PembelianDetail::where('id_pembelian', $pembelian->id_pembelian)->get();

        
        foreach ($detail as $item) {
            $produk = Produk::find($item->id_produk);
            // $checkProduk = Produk::where('id_produk', $item->id_produk);
            if ($produk) {
                if($produk->stok >= $item->jumlah ) {
                    $produk->stok -= $item->jumlah;    
                } 
                // elseif($checkProduk->stok >= $item->jumlah) {
                //     $produk->stok -= $item->jumlah;    
                // }
                else {
                    return redirect('/pembelian')->session()->flash('failed', 'Barang gagal disimpan');
                }   
                $produk->update();
            }
            $item->delete();
        }

        $pembelian->delete();

        return response(null, 204);
    }
}