<?php

namespace App\Http\Controllers;

use App\Models\PembelianDetail;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\Produk;
use App\Models\Pembelian;

class PembelianDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $id_pembelian = session('id_pembelian');
        $produk = Produk::orderBy('nama_produk')->get();
        $supplier = Supplier::find(session('id_supplier'));

        if (! $supplier) {
            abort(404);
        }

        return view('pembelian_detail.index', compact('id_pembelian', 'produk', 'supplier'));
    }

    public function data($id) 
    {
        $detail = PembelianDetail::with('produk')
            ->where('id_pembelian', $id)
            ->get();

        $data = array();
        $total = 0;
        $total_item = 0;

        foreach ($detail as $item) {
            $row = array();
        
            $row['barcode']     = '<span class="badge badge-info">' . $item->produk['barcode'] . '<span';
            $row['nama_produk'] = $item->produk['nama_produk'];
            $row['harga_beli']  = 'Rp. '. format_uang($item->harga_beli);
            $row['jumlah']      = '<input type="number" class="form-control input-sm quantity" data-id="'. $item->id_pembelian_detail .'" value="'. $item->jumlah .'"> ';
            $row['subtotal']    = 'Rp. '. format_uang($item->subtotal);
            $row['aksi']          = '<div class="btn-group"> 
                                        <button onclick="deleteData(`'. route('pembelian_detail.destroy', $item->id_pembelian_detail) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="bi bi-trash"></i></button>
                                    </div>';
            $data[] = $row;

            $total += $item->harga_beli * $item->jumlah;
            $total_item += $item->jumlah;
        }

        $data[] = [
            'barcode' => '
                <div class="total hide" style="visibility: hidden">'. $total .'</div>
                <div class="total_item hide" style="visibility: hidden">'. $total_item .'</div>',
            'nama_produk' => '',
            'harga_beli'  => '',
            'jumlah'      => '',
            'subtotal'    => '',
            'aksi'        => '',
        ];

        // return $data;

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->rawColumns(['aksi', 'barcode', 'jumlah'])
            ->make(true);

        // return datatables()
        //     ->of($detail)
        //     ->addIndexColumn()
        //     ->addColumn('barcode', function ($detail) {
        //         return '<span class="badge badge-info">' . $detail->produk['barcode'] . '</span>';
        //     })
        //     ->addColumn('nama_produk', function ($detail) {
        //         return $detail->produk['nama_produk'];
        //     })
        //     ->addColumn('harga_beli', function ($detail) {
        //         return 'Rp. ' . $detail->produk['harga_beli'] . ' ,-';
        //     })
        //     ->addColumn('jumlah', function ($detail) {
        //         return '<input type="number" class="form-control input-sm quantity" data-id="'. $detail->id_pembelian_detail .'" value="'. $detail->jumlah. '"> ';
        //     })
        //     ->addColumn('subtotal', function ($detail) {
        //         return 'Rp. ' . $detail->subtotal . ' ,-';
        //     })
        //     ->addColumn('ud', function ($detail) { 
        //         return ' 
        //             <button onclick="deleteData(`'. route('pembelian_detail.destroy', $detail->id_pembelian_detail) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="bi bi-trash"></i></button>
        //             '; 
        //         })
        //     ->rawColumns(['ud', 'barcode', 'jumlah'])
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
        $produk = Produk::where('id_produk', $request->id_produk)->first();

        if(! $produk) {
            return response()->json('Data gagal', 400);
        }

        $detail = new PembelianDetail();
        $detail->id_pembelian = $request->id_pembelian;
        $detail->id_produk = $produk->id_produk;
        $detail->harga_beli = $produk->harga_beli;
        $detail->jumlah = 1;

        $detail->subtotal = $produk->harga_beli;
        $detail->save(); 

        return response()->json('Data control', 200);
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
        $detail = PembelianDetail::find($id);
        $detail->jumlah = $request->jumlah;
        $detail->subtotal = $detail->harga_beli * $request->jumlah;
        $detail->update();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $detail = PembelianDetail::find($id);
        $detail->delete();

        return response(null,204);
    }

    public function loadForm($diskon, $total) {
         $bayar = $total - ($diskon / 100 * $total);
         $data = [
            'totalrp' => format_uang($total),
            'bayar' => $bayar,
            'bayarrp' => format_uang($bayar),
            'terbilang' => ucwords(terbilang($bayar). ' Rupiah' )
            // fungsi ucwords untuk mengubah satu huruf depan jadi kapital
        ];

        return response()->json($data);
    }
}
