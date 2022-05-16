<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\Setting;
use Illuminate\Http\Request;

class PenjualanDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produk = Produk::orderBy('nama_produk')->get();
        // $setting = Setting::first();

        

        // Cek Apakah ada Transaksi yang sedang berjalan

        if($id_penjualan = session('id_penjualan')) {
            return view('penjualandetail.index', compact('produk', 'id_penjualan'));
        } else {
            if(auth()->user()->level == 1) {
                return redirect()->route('transaksi.baru');
            } else {
                return redirect()->route('home');
            }
        }


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $penjualan = new Penjualan();
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
