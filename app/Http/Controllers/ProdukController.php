<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Satuan;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategori = Kategori::all()->pluck('nama_kategori', 'id_kategori');
        $satuan = Satuan::all()->pluck('nama_satuan', 'id_satuan');
        return view('produk.index', compact('kategori'), compact('satuan'));
    }

    public function data()
    {
        $produk = Produk::leftJoin('kategori', 'kategori.id_kategori', 'produk.id_kategori')
                    ->leftJoin('satuan', 'satuan.id_satuan', 'produk.id_satuan')
                    ->select('produk.*', 'nama_kategori', 'nama_satuan')
                    
                    ->orderBy('id_produk', 'desc')
                    ->get();

        return datatables()
            ->of($produk)
            ->addIndexColumn()
            ->addColumn('barcode', function ($produk) {
                return '<span class="badge badge-info">'. $produk->barcode .'</span>';
            })
            ->addColumn('harga_beli', function ($produk) {
                return format_uang($produk->harga_beli);
            })
            ->addColumn('harga_jual', function ($produk) {
                return format_uang($produk->harga_jual);
            })
            ->addColumn('stok', function ($produk) {
                return format_uang($produk->stok);
            })
            ->addColumn('ud', function($produk) { 
                return '
                    <button onclick="editData(`'. route('produk.update', $produk->id_produk).'`)" class="btn btn-xs btn-info btn-flat><i class=bi bi-pencil-square"><i/>Edit</button> 
                    <button onclick="deleteForm(`'. route('produk.destroy', $produk->id_produk) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="bi bi-trash"></i>Delete</button>
                    '; 
                })
            ->rawColumns(['ud', 'barcode'])
            ->make(true);

        // return datatables()
        //     ->of($produk)
        //     ->addIndexColumn()
        //     ->addColumn('act', function ($produk) {
        //         return '
        //             <button onclick="editForm(`'. route('produk.update', $produk->id_produk) .'`)" class="btn btn-xs btn-info btn-flat"><i class="bi bi-pencil-square"></i>Edit</button>
        //             <button onclick="deleteData(`'. route('produk.destroy', $produk->id_produk) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="bi bi-trash"></i>Delete</button>
        //         ';
        //     })
        //     ->rawColumns(['act'])
        //     ->make(true);
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
        $produk = Produk::latest()->first();
        $request['barcode'] = '202004'. tambah_nol_didepan((int)$produk->id_produk +1, 4);

        $produk = Produk::create($request->all());
        // $produk->save();
        // $produk = new Produk();
        // $produk->nama_produk= $request->nama_produk;
        // $produk->nama_kategori= $request->id_kategori;
        // $produk->nama_satuan= $request->id_satuan;
        // $produk->harga_beli= $request->harga_beli;
        // $produk->harga_jual= $request->harga_jual;
        // $produk->diskon= $request->diskon;
        // $produk->stok= $request->stok;
        // $produk->save();

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produk = Produk::find($id);
        
        return response()->json($produk);
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
        $produk = Produk::find($id);
        $produk->update($request->all());

        return response()->json('Data berhasil diubah', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produk = Produk::find($id);
        $produk->delete();

        return response(null,204);
    }
}
