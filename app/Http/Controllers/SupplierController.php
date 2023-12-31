<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\Produk;
use App\Models\ProdukSupplier;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produk = Produk::all();
        $supplier = Supplier::all();
        $produk_supplier = ProdukSupplier::all();
        return view('supplier.index', compact('produk', 'supplier', 'produk_supplier'));
    }

    public function data() 
    {
        $supplier = Supplier::orderBy('id_supplier', 'desc')->get();

        return datatables()
            ->of($supplier)
            ->addIndexColumn()
            ->addColumn('aksi', function ($supplier) {
                return '
                    <div class="btn-group">
                        <button onclick="editData(`'. route('supplier.update', $supplier->id_supplier).'`)"  class="btn btn-sm btn-success btn-flat"><i class="bi bi-pencil-square"></i></button>&nbsp;&nbsp;
                        <button onclick="deleteData(`'. route('supplier.destroy', $supplier->id_supplier) .'`)" class="btn btn-sm btn-danger btn-flat"><i class="bi bi-trash"></i></button>&nbsp;&nbsp;
                        <button id="tambahProdukSupplier" data-id_supplier="'.$supplier->id_supplier.'" class="btn btn-sm btn-primary"><i class="fa fa-plus-circle"></i></button>
                    </div>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function simpanProduk(Request $request)
    {
        foreach ($request->id_produk as $key => $value) {
            $produk_supplier = new ProdukSupplier();
            $produk_supplier->id_supplier = $request->id_supplier;
            $produk_supplier->id_produk = $value;

            $produk_supplier->save();
        }

        return response([
            'status' => true,
            'message' => 'Produk berhasil ditambahkan!'
        ], 200);
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
        // $supplier = Supplier::create($request->all());
        // $validasiNama = Supplier::find('nama');
        $supplier = new Supplier();

        // $validasi = $request->validate([
        //     'nama' => 'unique:supplier'
        // ]);

        $supplier->nama = $request->nama;

        // if($request->nama == $validasiNama)
        // {
        //     // ([
        //     //     'status' => false,
        //     //     'message' => 'gagal'
        //     // ]);
        // } else {
        //     $supplier->nama = $request->nama;
        // }

        $supplier->alamat = $request->alamat;
        $supplier->telepon = $request->telepon;
        $supplier->save();

        // $validatedData = $request->validate([
        //     'nama' => 'required|max:255|unique:users',
        //     'alamat' => 'required',
        //     'telepon' => 'required|min:10|max:13'
        // ]);

        // $validatedData['password'] = bcrypt($validatedData['password']);
        // $validatedData['password'] = Hash::make($validatedData['password']);

        // Supplier::create($validatedData);

        return redirect('/supplier')->with('alert', 'Supplier baru berhasil ditambahkan');
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
        $supplier->nama = $request->nama;
        $supplier->alamat = $request->alamat;
        $supplier->telepon = $request->telepon;
        $supplier->update();

        return redirect('/supplier')->with('alert2', 'Supplier berhasil diupdate');
        // return response()->json('berhasil', 200);
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
        
        // $produk_supplier = ProdukSupplier::where('id_supplier', $supplier->id_supplier)->delete();
        
        // dd($supplier);

        // DB::table('produk_supplier')->where('id_supplier', $supplier->id_supplier)->delete();
        // $supplier->produk()->detach();
        $supplier->delete();
        // if(Supplier::destroy($id)){
        //     return 'success';
        // }else{
        //     return 'fail';
        // }

        // return redirect('/supplier')->with('delete', 'Berhasil Diupdate');

        return response(null,200);
    }
}
