<?php

namespace App\Http\Controllers;

use App\Models\PengembalianBarang;
use App\Models\Produk;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PengembalianBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produk = Produk::all()->pluck('id_produk', 'nama_produk');
        $supplier = Supplier::all()->pluck('id_supplier', 'nama');

        return view('pengembalianBarang.index', compact('supplier', 'produk'));
    }

    public function data()
    {
        // $pengembalianBarang = PengembalianBarang::orderBy('id_pengembalian_barang', 'DESC')->get();
        $pengembalianBarang = PengembalianBarang::leftJoin('produk', 'produk.id_produk', 'pengembalian_barang.id_produk')
                                ->leftJoin('supplier', 'supplier.id_supplier', 'pengembalian_barang.id_supplier')
                                ->select('pengembalian_barang.*', 'nama_produk', 'nama')     
                                ->orderBy('id_pengembalian_barang', 'desc')
                                ->get();

        return datatables()
            ->of($pengembalianBarang)
            ->addIndexColumn()
            ->addColumn('tanggal', function($pengembalianBarang) {
                return tanggal_indonesia($pengembalianBarang->created_at, false);
            })
            ->addColumn('barcode', function ($pengembalianBarang) {
                return '<span class="badge badge-info">'. $pengembalianBarang->produk->barcode .'</span>';
            })
            // ->addColumn('nama_produk', function ($pengembalianBarang) {
            //     return $pengembalianBarang->produk->nama_produk;
            // })
            ->addColumn('jumlah', function ($pengembalianBarang) {
                return $pengembalianBarang->jumlah;
            })
            ->addColumn('keterangan', function ($pengembalianBarang) {
                return $pengembalianBarang->keterangan;
            })
            ->addColumn('harga', function ($pengembalianBarang) {
                return 'Rp. '. format_uang($pengembalianBarang->produk->harga_beli * $pengembalianBarang->jumlah) .',-';
            })
            ->addColumn('aksi', function($pengembalianBarang) { 
                return '
                    <button onclick="editForm (`'. route('pengembalianBarang.update', $pengembalianBarang->id_pengembalian_barang).'`)
                        " class="btn btn-xs btn-success btn-flat><i class=bi bi-pencil-square"><i/> Edit</button>
                    <button onclick="deleteForm(`'. route('pengembalianBarang.destroy', $pengembalianBarang->id_pengembalian_barang) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="bi bi-trash"></i> Hapus</button>
                    '; 
                })
            ->rawColumns(['aksi', 'barcode' ])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pengembalian = PengembalianBarang::create($request->all())->save();

        $detail = PengembalianBarang::where('id_pengembalian_barang', $pengembalian->id_pengembalian_barang)->get();
        foreach ($detail as $item) {
            $produk = Produk::find($item->id_produk);
            $produk->stok -= $item->jumlah;
            $produk->update();
        }

        return $pengembalian;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $pengembalian = PengembalianBarang::find($id);
        $pengembalian->update($request->all());

        return response()->json('Data Pengembalian berhasil diupdate', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pengembalian = PengembalianBarang::find($id);
        $pengembalian->delete();

        return response(null,204);
    }
}