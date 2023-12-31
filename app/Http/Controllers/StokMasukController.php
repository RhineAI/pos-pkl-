<?php

namespace App\Http\Controllers;

use App\Models\PembelianDetail;
use App\Models\Produk;
use App\Models\Satuan;
use App\Models\StokMasuk;
use Illuminate\Http\Request;

class StokMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $produk = Produk::orderBy('nama_produk')->get();
        $satuan = Satuan::orderBy('id_satuan', 'desc')->get();

        return view('stokmasuk.index', compact('produk'), compact('satuan'));
    }

    public function data() {
        $stokmasuk = StokMasuk::leftJoin('produk', 'produk.id_produk', 'produk.id_produk')
                            ->select('stok_masuk.*','nama_produk')
                            ->orderBy('id_stok_masuk', 'desc')
                            ->get();               
                            
        return datatables()
        ->of($stokmasuk)
        ->addIndexColumn()
        ->addColumn('tanggal', function($stokmasuk) {
            return tanggal_indonesia($stokmasuk->created_at, false);
        })
        ->addColumn('jumlah', function($stokmasuk) {
            return format_uang($stokmasuk->jumlah) . ' qty';
        })
        ->addColumn('barcode', function ($stokmasuk) {
            return '<span class="badge badge-info">'. $stokmasuk->produk->barcode .'</span>';
        })
        // ->addColumn('nama_produk', function($stokmasuk) {
        //     return $stokmasuk->produk->nama_produk;
        // })
        ->addColumn('keterangan', function($stokmasuk) {
            return $stokmasuk->keterangan;
        })
        ->addColumn('aksi', function ($stokmasuk) {
            return '
                <button onclick="deleteData(`'. route('stokmasuk.destroy', $stokmasuk->id_stok_masuk) .'`)" class="btn btn-xs btn-danger delete"><i class="bi bi-trash"></i></button>
            ';
        })
        ->rawColumns(['aksi', 'barcode'])
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
        // $produk = Produk::where('id_produk', $request->id_produk)->first();

        // if(! $produk) {
        //     return response()->json('Data gagal', 400);
        // }

        $detail = new StokMasuk();
        $detail->id_produk = $request->id_produk;
        $detail->jumlah = $request->jumlah;
        $detail->keterangan = $request->keterangan;
        $detail->save();
        
        // $tambahData = StokMasuk::Where('id_stok_masuk', $detail->id_stok_masuk)->get();
        // foreach ($tambahData as $item) {
        //     $produk = Produk::find($item->id_produk);
        //     $produk->stok += $item->jumlah;
        //     $produk->update();
        // }

       return $detail;

        // $detail = StokMasuk::create($request->all())->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
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
        $data = StokMasuk::find($id);
        $data->delete();

        return response(null,204);
    }
}
