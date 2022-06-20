<?php

namespace App\Http\Controllers;

use App\Models\Pengembalian;
use Illuminate\Http\Request;

class ReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('return_barang.index');
        
    }

    public function data()
    {
        $pengembalian = Pengembalian::orderBy('id_pengembalian', 'desc')->get();

        return datatables()
            ->of($pengembalian)
            ->addIndexColumn()
            ->addColumn('tanggal', function($pengembalian) {
                return tanggal_indonesia($pengembalian->created_at, false);
            })
            ->addColumn('invoice', function($pengembalian) {
                return '<span class="badge badge-danger">'. $pengembalian->kode_pembelian .'</span>';

            })
            ->addColumn('nama_produk', function($pengembalian) {
                return $pengembalian->nama_produk ;
            })
            ->addColumn('barcode', function($pengembalian) {
                return '<span class="badge badge-info">'. $pengembalian->barcode .'</span>';
            })
            ->addColumn('jumlah_awal', function($pengembalian) {
                return $pengembalian->jumlah_awal + $pengembalian->jumlah_retur;
            })
            ->addColumn('jumlah_retur', function($pengembalian) {
                return $pengembalian->jumlah_retur;
            })
            ->rawColumns(['invoice', 'barcode'])
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
        //
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
        //
    }
}
