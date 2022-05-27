<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\PembelianDetail;
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
        // $produk = Produk::all()->pluck('id_produk', 'nama_produk');
        // $supplier = Supplier::all()->pluck('id_supplier', 'nama');
        $pembelian = Pembelian::orderBy('id_pembelian', 'desc')->get();

        // $pembelian = Pembelian::all()->pluck('id_pembelian', 'kode_pembelian');
        // $pembelianDetail = PembelianDetail::where('id_pembelian', $pembelian->id_pembelian);

        return view('pengembalianBarang.index', compact('pembelian'));
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
            ->addColumn('invoice', function($pengembalianBarang) {
                return $pengembalianBarang->invoice;
            })
            // ->addColumn('barcode', function ($pengembalianBarang) {
            //     return '<span class="badge badge-info">'. $pengembalianBarang->produk->barcode .'</span>';
            // })
            ->addColumn('nama_produk', function ($pengembalianBarang) {
                return $pengembalianBarang->produk->nama_produk;
            })
            ->addColumn('jumlah_asal', function ($pengembalianBarang) {
                return $pengembalianBarang->jumlah_asal;
            })
            ->addColumn('jumlah_kembali', function ($pengembalianBarang) {
                return $pengembalianBarang->jumlah_kembali;
            })
            ->addColumn('subtotal', function ($pengembalianBarang) {
                return 'Rp. '. format_uang($pengembalianBarang->produk->harga_beli * $pengembalianBarang->jumlah_kembali) .',-';
            })
            ->addColumn('aksi', function($pengembalianBarang) { 
                return '
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
        
        $pengembalian = new PengembalianBarang();
        $pengembalian->id_produk = $request->id_produk;
        $pengembalian->id_supplier = $request->id_supplier;
        
        // $produk = Produk::find('id_produk')->where('id_produk', $request->id_produk)->get();
        // if($request->jumlah >= $produk->stok){
        //     $pengembalian->jumlah = $request->jumlah;
        // } else {
        //     return response()->json([
        //         'status' => true,
        //         'message' => 'Stok di master data kurang'
        //     ]);
        // }
        $pengembalian->jumlah = $request->jumlah;
        $pengembalian->keterangan = $request->keterangan;
        $pengembalian->save();

        $findProduct = Produk::find($pengembalian->id_produk);

        $findProduct->stok -= $pengembalian->jumlah;
        $findProduct->save();

        return response()->json([
            'status' => true,
            'message' => 'Pengembalian barang berhasil!',
        ], 200);

    }

    public function findProduct(Request $request){
        if ($request->ajax()) {
            $product = Produk::where('id_produk', $request->id_produk)->first();

            return response()->json([
                'status' => true,
                'message' => 'success get product',
                'data' => $product
            ]);
        }
    }

    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pengembalian = PengembalianBarang::find($id);
        
        return response()->json($pengembalian);
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
        $findProduct = Produk::find($pengembalian->id_produk);

        if($pengembalian->jumlah >= $request->jumlah){
            $findProduct->stok += $pengembalian->jumlah;   

            $findProduct->stok -= $request->jumlah;
            $findProduct->update();
        } else{
            $findProduct->stok += $pengembalian->jumlah;   

            $findProduct->stok -= $request->jumlah;
            $findProduct->update();
        }
   
        $pengembalian->id_produk = $pengembalian->id_produk;

        // if($pengembalian->id_produk == $request->id_produk)
        // {
        //     if($pengembalian->jumlah >= $request->jumlah){
        //         $findProduct->stok += $request->id_produk->
            
        //         $findProduct->stok += $pengembalian->jumlah;   
    
        //         $findProduct->stok -= $request->jumlah;
        //         $findProduct->update();
        //     } else{
        //         $findProduct->stok += $pengembalian->jumlah;   
    
        //         $findProduct->stok -= $request->jumlah;
        //         $findProduct->update();
        //     }
        // }else{

        // }

        $pengembalian->jumlah = $request->jumlah;
        $pengembalian->id_supplier = $request->id_supplier;
        $pengembalian->keterangan = $request->keterangan;

        $pengembalian->update();

        


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
        // $pengembalian = PengembalianBarang::find($id);
        // $pengembalian->delete();

        // return response(null,204);

        $pengembalian = PengembalianBarang::find($id);
        $detail    = PengembalianBarang::where('id_pengembalian_barang', $pengembalian->id_pengembalian_barang)->get();
        foreach ($detail as $item) {
            $produk = Produk::find($item->id_produk);
            if ($produk) {
                $produk->stok += $item->jumlah;
                $produk->update();
            }
            $item->delete();
        }

        $pengembalian->delete();

        return response(null, 204);
    }
}
