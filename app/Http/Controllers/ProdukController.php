<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Satuan;
use Barryvdh\DomPDF\Facade\Pdf;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategori = Kategori::all()->pluck('id_kategori', 'nama_kategori');
        $satuan = Satuan::all()->pluck('id_satuan', 'nama_satuan');
        return view('produk.index', compact('kategori'), compact('satuan'));
    }

    public function checkPrice($value)
    {
        if (gettype($value) == "string") {
            $temp = 0;
            for ($i = 0; $i < strlen($value); $i++) {
                if ((isset($value[$i]) == true && $value[$i] != ".") && $value[$i] != ",") {
                    $temp = ($temp * 10) + (int)$value[$i];
                }
            }
            return $temp;
        } else {
            return $value;
        }
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
            ->addColumn('select_all', function ($produk) {
                return '<input type="checkbox" name="id_produk[]" value=" '. $produk->id_produk.' ">
                ';
            })
            ->addColumn('barcode', function ($produk) {
                return '<span class="badge badge-info">'. $produk->barcode .'</span>';
            })
            ->addColumn('harga_beli', function ($produk) {
                return 'Rp. '. format_uang($produk->harga_beli);
            })
            ->addColumn('harga_jual', function ($produk) {
                return 'Rp. '. format_uang($produk->harga_jual);
            })
            ->addColumn('stok', function ($produk) {
                // if($produk->stok < 1)
                // {
                //     $stok = 'Habis';
                // }
                return format_uang($produk->stok);
            })
            ->addColumn('ud', function($produk) { 
                return '
                    <button onclick="editData(`'. route('produk.update', $produk->id_produk).'`)" class="btn btn-xs btn-success btn-flat><i class=bi bi-pencil-square"><i/></button>
                    <button onclick="deleteForm(`'. route('produk.destroy', $produk->id_produk) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="bi bi-trash"></i></button>
                    '; 
                })
            ->rawColumns(['ud', 'barcode', 'select_all'])
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
        $produk = Produk::select('barcode')->orderBy('created_at', 'DESC')->first();
        
        $kode = '';

        if($produk == NULL) {
            $kode = 'BRC-202205001';
        } else {
            $kode = sprintf('BRC-202205%03d', substr($produk->barcode, 10) + 1);
            // $kode = sprintf('BRC-202205%03d' + 1);
        }

        $request['barcode'] = $kode;

        // $produk = Produk::latest()->first() ?? new Produk();
        // $request['barcode'] = 'iL-'. tambah_nol_didepan((int)$produk->id_produk + 1, 4);

        $request['harga_beli'] = $this->checkPrice($request->harga_beli);
        $request['harga_jual'] = $this->checkPrice($request->harga_jual);

        // $stok = '';

        // $request['stok'] = 

        $produk = Produk::create($request->all())->save();

        return response()->json('Data Produk baru berhasil ditambahkan', 200);

        // $produk->save();
        
        // return response()->json('Data simpan', 200);
        // $produk = new Produk();
        // $produk->nama_produk= $request->nama_produk;
        // $produk->nama_kategori= $request->nama_kategori;
        // $produk->nama_satuan= $request->nama_satuan;
        // $produk->harga_beli= $request->harga_beli;
        // $produk->harga_jual= $request->harga_jual;
        // $produk->diskon= $request->diskon;
        // $produk->stok= $request->stok;
        // $produk->save();

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

        return response()->json('Data Produk berhasil diupdate', 200);
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

    // public function deleteSelected(Request $request) 
    // {

    //     foreach ($request->id_produk as $produk => $id) {
    //         $produk = Produk::find($id);
    //         $produk->delete();

    //     }
    //     return response(null, 204);
    // }

    // public function cetakBarcode(Request $request) 
    // {
    //     $dataProduk = array();
    //     foreach ($request->id_produk as $id) {
    //         $produk = Produk::find($id);
    //         $dataProduk[] = $produk;
    //     }

    //     $pdf = Pdf::loadView('produk.barcode', compact('dataProduk'));
    //     $pdf->setPaper('a4', 'potrait');
    //     return $pdf;
    // }
}
