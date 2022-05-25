<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\PenjualanDetail;
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
        // $id_penjualan = session('id_penjualan');
        $produk = Produk::orderBy('nama_produk')->get();
        // $diskon = Penjualan::find($id_penjualan)->diskon ?? 0;
        $diskon = Penjualan::first()->diskon ?? 0;

        $detail = PenjualanDetail::orderBy('id_penjualan_detail', 'DESC');
        // $setting = Setting::first();

        

        // Cek Apakah ada Transaksi yang sedang berjalan

        if($id_penjualan = session('id_penjualan')) {
            $penjualan = Penjualan::find($id_penjualan);

            return view('penjualan_detail.index', compact('produk', 'id_penjualan', 'penjualan', 'diskon'));
        } else {
            if(auth()->user()->level == 1) {
                return redirect()->route('transaksi.baru');
            } else {
                return redirect()->route('home');
            }
        }
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

    

    public function data($id)
    {
        $detail = PenjualanDetail::with('produk')
            ->where('id_penjualan', $id)
            ->get();
        $data = array();
        $total = 0;
        $total_item = 0;

        foreach ($detail as $item) {
            $row = array();
            $row['barcode']     = '<span class="badge badge-info">'. $item->produk->barcode .'</span>';
            $row['nama_produk'] = $item->produk['nama_produk'];
            $row['harga_jual']  = 'Rp. '. format_uang($item->produk->harga_jual);
            $row['jumlah']      = '<input type="number" class="form-control input-sm quantity" data-id="'. $item->id_penjualan_detail .'" value="'. $item->jumlah .'">';
                
            $row['subtotal']    = 'Rp. '. format_uang($item->subtotal);
            $row['aksi']        = '<div class="btn-group">
                                    <button onclick="deleteData(`'. route('transaksi.destroy', $item->id_penjualan_detail) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i> Hapus</button>
                                </div>';
            $data[] = $row;

            $total += $item->harga_jual * $item->jumlah;
            $total_item += $item->jumlah;
        }
        $data[] = [
            'barcode' => '
                <div class="total hide" style="visibility: hidden">'. $total .'</div>
                <div class="total_item hide" style="visibility: hidden">'. $total_item .'</div>',
            'nama_produk' => '',
            'harga_jual'  => '',
            'jumlah'      => '',
            'subtotal'    => '',
            'aksi'        => '',
        ];

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->rawColumns(['aksi', 'barcode', 'jumlah'])
            ->make(true);
    }   

    function loadForm($diskon = 0, $total, $diterima)
    {
        $bayar = $total - ($diskon / 100 * $total) ;
        $kembali = ($this->checkPrice($diterima) != 0) ? $this->checkPrice($diterima) - $bayar : 0;
        $data  = [
            'totalrp' => format_uang($total),
            'bayar' => $bayar,
            'bayarrp' => format_uang($bayar),
            'terbilang' => ucwords(terbilang($bayar). ' Rupiah'),
            'kembalirp' => format_uang($kembali),
            'kembali_terbilang' => ucwords(terbilang($kembali). ' Rupiah')
        ];

        return response()->json($data);
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
        $produk = Produk::where('id_produk', $request->id_produk)->first();
        if (! $produk) {
            return response()->json('Data gagal disimpan', 400);
        }

        // $checkBarang = $this->db->get_where('penjualan_detail', ['id_produk' => $produk])->row_array();
        // $penjualan = PenjualanDetail::where('id_penjualan_detail', $request->id_produk); 

        // if($penjualan->id_produk == $request->id_produk) {
        //     //maka update
        //     $update = $penjualan->jumlah + 1;
        //     $update->update();

        // }else {
            $detail = new PenjualanDetail();
            $detail->id_penjualan = $request->id_penjualan;
            $detail->id_produk = $produk->id_produk;
            // if($request->id_produk == $detail->produk){
            //     $detail->jumlah + 1;
            // }

            $detail->harga_jual = $produk->harga_jual;
            
            if ( $request->barcode != $produk->barcode) {
                $detail->jumlah + 0;
            } else {
                
                $detail->jumlah + 1;
            }

            if ($produk->stok <= $request->jumlah)
            {
                $this->session->set_flashdata('error', 'Jumlah Barang melebihi stok');
            } else
            {
                $detail->jumlah = 1;
            }

            $detail->diskon = 0;
            $detail->subtotal = $produk->harga_jual;
            $detail->save();

            return response()->json('Data berhasil disimpan', 200);
        // }

        
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
        $detail = PenjualanDetail::find($id);
        $detail->jumlah = $request->jumlah;
        $detail->subtotal = $detail->harga_jual * $request->jumlah;
        $detail->update();
    }

    /** bagi tutor crud
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $detail = PenjualanDetail::find($id);
        $detail->delete();

        return response(null, 204);
    }
}
