<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\PembelianDetail;
use App\Models\Pengembalian;
use App\Models\Produk;
use App\Models\ProdukSupplier;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PembelianDetailController extends Controller
{
    public function index()
    {
        $id_pembelian = session('id_pembelian');
        $supplier = Supplier::where('id_supplier', '=', session('id_supplier'))->with('produk')->get();
        $findSupplier = Supplier::find(session('id_supplier'));
        // dd($supplier);
        $diskon = Pembelian::find($id_pembelian)->diskon ?? 0;

        if (! $supplier) {
            abort(404);
        }

        return view('pembelian_detail.index', compact('id_pembelian', 'supplier', 'findSupplier', 'diskon'));
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
        $detail = PembelianDetail::with('produk')
            ->where('id_pembelian', $id)
            ->get();
        $data = array();
        $total = 0;
        $total_item = 0;

        foreach ($detail as $item) {
            $row = array();
            $row['barcode']     = '<span class="badge badge-info">'. $item->produk->barcode .'</span>';
            $row['nama_produk'] = $item->produk['nama_produk'];
            $row['harga_beli']  = 'Rp. '. format_uang($item->harga_beli);
            $row['jumlah']      = '<input type="number" class="form-control input-sm quantity" data-id="'. $item->id_pembelian_detail .'" value="'. $item->jumlah .'">';
            $row['subtotal']    = 'Rp. '. format_uang($item->subtotal);
            $row['aksi']        = '<div class="btn-group">
                                    <button onclick="deleteData(`'. route('pembelian_detail.destroy', $item->id_pembelian_detail) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i> Hapus</button>
                                </div>';
            $data[] = $row;

            $total += $item->harga_beli * $item->jumlah;
            $total_item += $item->jumlah;
        }
        $data[] = [
            'barcode' => '
                <div class="total hide" style="visibility : hidden">'. $total .'</div>
                <div class="total_item hide" style="visibility : hidden">'. $total_item .'</div>',
            'nama_produk' => '',
            'harga_beli'  => '',
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

    public function store(Request $request)
    {
        $produk = Produk::where('id_produk', $request->id_produk)->first();
        if (! $produk) {
            return response()->json('Data gagal disimpan', 400);
        }


        $detail = new PembelianDetail();
        $detail->id_pembelian = $request->id_pembelian;
        $detail->id_produk = $produk->id_produk;
        $detail->harga_beli = $produk->harga_beli;
        $detail->jumlah = 1;
        $detail->subtotal = $produk->harga_beli;
        $detail->save();

        return response()->json('Data berhasil disimpan', 200);
    }

    public function return(Request $request)
    {

    }

    public function update(Request $request, $id)
    {
        $detail = PembelianDetail::find($id);
        $detail->jumlah = $request->jumlah;
        $detail->subtotal = $detail->harga_beli * $request->jumlah;
        $detail->update();
    }

    public function destroy($id)
    {
        $detail = PembelianDetail::find($id);
        $detail->delete();

        return response(null, 204);
    }

    public function cancel($id) {
        $pembelian = Pembelian::find($id);

        $detail    = PembelianDetail::where('id_pembelian', $pembelian->id_pembelian)->get();
        foreach ($detail as $item) {
            $produk = Produk::find($item->id_produk);
            if ($produk) {
                $produk->stok -= $item->jumlah;
                $produk->update();
            }

            $item->delete();
        }

        $pembelian->delete();

        return redirect('/dashboard');
    }

    public function return_barang(Request $request)
    {
        $pembelianDetail = PembelianDetail::find($request->id_pembelian_detail);

        $jumlahRetur = $request->jumlah;
        $jumlahBaru = ($pembelianDetail->jumlah - $jumlahRetur);
        
        $pembelianDetail->jumlah = $jumlahBaru;
        $pembelianDetail->subtotal = $jumlahBaru * $pembelianDetail->harga_beli;
        $pembelianDetail->save();

        $id = 0;
        $harga_beli = 0;
        $jumlah = 0;

        $ambilDetail = PembelianDetail::where('id_pembelian', $pembelianDetail->id_pembelian)->get();

        foreach ($ambilDetail as $key => $value) {
            $id = $value->id_pembelian;
            $harga_beli += $value->subtotal;
            $jumlah += $value->jumlah;
        }

        // return $ambilDetail;

        $updatePembelian = Pembelian::find($id);
        $updatePembelian->total_item = $jumlah;
        $updatePembelian->total_harga = $harga_beli;

        $rumusDiskonYagesYa = ($harga_beli * $updatePembelian->diskon) / 100; 

        if ($updatePembelian->diskon > 0) {
            $updatePembelian->bayar = $harga_beli - $rumusDiskonYagesYa;
        } else {
            $updatePembelian->bayar = $harga_beli;
        }

        $updatePembelian->save();

        // History insert here  
        // $ambilInvoice = Pembelian::where('id_pembelian', $ambilDetail->id_pembelian);
        // $produk = Produk::where('id_produk', $updatePembelian->id_produk);

        $insertHistory = new Pengembalian();
        $insertHistory->kode_pembelian = $updatePembelian->kode_pembelian;
        $insertHistory->nama_produk = $pembelianDetail->produk->nama_produk;
        // $insertHistory->satuan = $pembelianDetail->produk->id_satuan;
        $insertHistory->barcode = $pembelianDetail->produk->barcode;
        $insertHistory->jumlah_awal = $pembelianDetail->jumlah;
        $insertHistory->jumlah_retur = $jumlahRetur;
        $insertHistory->save();

        // End insert HISTORY

        if ($updatePembelian->total_item == 0) {
            PembelianDetail::where('id_pembelian', $updatePembelian->id_pembelian)->delete();
            Pembelian::find($id)->delete();
        } else if ($pembelianDetail->jumlah == 0) {
            PembelianDetail::where('id_pembelian_detail', $pembelianDetail->id_pembelian_detail)->delete();
        }

        $barang = Produk::find($pembelianDetail->id_produk);
        $barang->stok -= $jumlahRetur;
        $barang->save();

        return response()->json([
            'status' => true,
            'message' => 'success return produk',
            'data' => $barang
        ], 200);
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
}