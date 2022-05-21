<?php

namespace App\Http\Controllers;

use App\Models\Produk;
// use App\Models\ProdukSupplier;
use App\Models\ProdukSupplier;
use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produk = Produk::orderBy('nama_produk')->get();
        // $produkSupp = ProdukSupplier::orderBy('id_produk_supplier', 'desc')->get();

        return view('supplier.index', compact('produk'));
    }

    public function data() 
    {
        $supplier = Supplier::orderBy('id_supplier', 'desc')->get();

        return datatables()
            ->of($supplier)
            ->addIndexColumn()
            ->addColumn('aksi', function ($supplier) {
                return '
                    <button onclick="tambahProduk()"  class="btn btn-xs btn-success btn-flat"><i class="fa-solid fa-plus"></i></button>
                    <button onclick="editData(`'. route('supplier.update', $supplier->id_supplier).'`)"  class="btn btn-xs btn-success btn-flat"><i class="bi bi-pencil-square"></i></button>
                    <button onclick="deleteData(`'. route('supplier.destroy', $supplier->id_supplier) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="bi bi-trash"></i></button>
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
        $supplier = Supplier::create($request->all());
        $supplier->save();

        return response()->json('Supplier baru berhasil ditambahkan', 200);
        // $produkSupp = ProdukSupplier::create($request->all());
        // $produkSupp->save();
    }

    public function tambah(Request $request)
    {
        $produkSupplier = new ProdukSupplier();
        $produkSupplier->id_produk = $request->id_produk; 
        $produkSupplier->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $supplier = Supplier::find($id);
        
        return response()->json($supplier);
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
        $supplier = Supplier::find($id);
        $supplier->update($request->all());

        return response()->json('Supplier berhasil diupdate', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplier = Supplier::find($id);
        $supplier->delete();

        return response(null,204);
    }
}
