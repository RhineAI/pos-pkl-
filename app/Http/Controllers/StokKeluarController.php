<?php

namespace App\Http\Controllers;

use App\Models\PembelianDetail;
use App\Models\Produk;
use App\Models\StokKeluar;
use App\Models\StokMasuk;
use Illuminate\Http\Request;

class StokKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $produk = Produk::orderBy('nama_produk')->get();

        $produk = Produk::all()->pluck('id_produk', 'nama_produk');
        return view('stokkeluar.index', compact('produk'));
    }

    public function data() {
        $stokkeluar = StokKeluar::leftJoin('produk', 'produk.id_produk', 'produk.id_produk')
                            ->select('stok_keluar.*','nama_produk')
                            ->orderBy('id_stok_keluar', 'desc')
                            ->get();               
                            
        return datatables()
        ->of($stokkeluar)
        ->addIndexColumn()
        ->addColumn('tanggal', function($stokkeluar) {
            return tanggal_indonesia($stokkeluar->created_at, false);
        })
        ->addColumn('jumlah', function($stokkeluar) {
            return format_uang($stokkeluar->jumlah) . ' qty';
        })
        ->addColumn('barcode', function ($stokkeluar) {
            return '<span class="badge badge-info">'. $stokkeluar->produk->barcode .'</span>';
        })
        ->addColumn('nama_produk', function($stokkeluar) {
            return $stokkeluar->produk->nama_produk;
        })
        ->addColumn('keterangan', function($stokkeluar) {
            return $stokkeluar->keterangan;
        })
        ->addColumn('aksi', function ($stokkeluar) {
            return '
                <button onclick="deleteData(`'. route('stokkeluar.destroy', $stokkeluar->id_stok_keluar) .'`)" class="btn btn-xs btn-danger delete"><i class="bi bi-trash"></i></button>
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

        $detail = new StokKeluar();
        $detail->id_produk = $request->id_produk;
        $detail->jumlah = $request->jumlah;
        $detail->keterangan = $request->keterangan;
        $detail->save();
        
        $tambahData = StokMasuk::Where('id_stok_masuk', $detail->id_stok_masuk)->get();
        foreach ($tambahData as $item) {
            $produk = Produk::find($item->id_produk);
            $produk->stok -= $item->jumlah;
            $produk->update();
        }

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
