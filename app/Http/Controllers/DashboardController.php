<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Supplier;
use App\Models\Pembelian;
use App\Models\Penjualan;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {      
        $produk = Produk::count();
        $supplier = Supplier::count();
        $seluruh_pembelian = Pembelian::count();
        $seluruh_penjualan = Penjualan::count();

        $TanggalAwal = date('Y-m-01');
        $TanggalAkhir = date('Y-m-d');

        $tanggal_awal = date('Y-m-01');
        $tanggal_akhir = date('Y-m-d');
        

        $data_tanggal = array();
        $data_pengeluaran = array();
        $data_pendapatan = array();

        // data pengeluaran dan pendapatan
        while (strtotime($tanggal_awal) <= strtotime($tanggal_akhir)) {
            $data_tanggal[] = (int) substr($tanggal_awal, 8, 2);

            $total_pembelian = Pembelian::where('created_at', 'LIKE', "%$tanggal_awal%")->sum('bayar');
            $total_penjualan = Penjualan::where('created_at', 'LIKE', "%$tanggal_awal%")->sum('bayar');
            
            $penjualan = Penjualan::first();

            $pengeluaran = $total_pembelian;
            $data_pengeluaran[] += $pengeluaran;
            $pendapatan = $total_penjualan;
            $data_pendapatan[] += $pendapatan;


            $tanggal_awal = date('Y-m-d', strtotime("+1day", strtotime($tanggal_awal)));

        }


        // // data pendapatan
        // while (strtotime($tanggal_awal) <= strtotime($tanggal_akhir)) {
        //     $data_tanggal[] = (int) substr($tanggal_awal, 8, 2);
            
        //     $total_penjualan = Penjualan::where('created_at', 'LIKE', "%$tanggal_awal%")->sum('bayar');
            
        //     $penjualan = Penjualan::first();

        //     $pendapatan = $total_penjualan;
        //     $data_pendapatan[] += $pendapatan;
            
        //     $tanggal_awal = date('Y-m-d', strtotime("+1day", strtotime($tanggal_awal)));
        // }

        if (auth()->user()->level == 1) {
            return view('admin.dashboard', compact('produk', 'supplier', 'TanggalAwal', 'TanggalAkhir', 'tanggal_awal', 'tanggal_akhir', 'seluruh_pembelian', 'seluruh_penjualan', 'data_tanggal', 'data_pengeluaran', 'data_pendapatan'));
        } else {
            return view('kasir.dashboard', compact('produk', 'supplier', 'TanggalAwal', 'TanggalAkhir', 'tanggal_awal', 'tanggal_akhir', 'seluruh_pembelian', 'seluruh_penjualan', 'data_tanggal', 'data_pengeluaran', 'data_pendapatan'));
        }
        
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
