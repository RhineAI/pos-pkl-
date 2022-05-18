@extends('layouts.main')

@section('title')
    Transaksi Penjualan
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Transaksi Penjualan</li>
@endsection

@section('content')
@stack('css')
<style>
     * {
            
        }
        p {
            display: block;
            margin: 3px;
            font-size: 12pt;
        }
        table td {
            font-size: 11pt;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .preview{
            margin-left: 300px;
            width: 464px;
            font-family: "consolas", sans-serif;
            padding: 32px;
            border: 2px dotted black;
        }
        .button{
            float: right;
            padding-right: 230px;
            padding-top: 30px;
            padding-bottom: 15px;
            
        }
          
</style>

<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-body mx-3">
                <div class="alert alert-success alert-dismissible">
                    <i class="fa fa-check icon"></i>
                    Data Transaksi telah selesai.
                </div>

                <h2 class="mb-4 mt-6 text-center">Preview</h2>

               <div class="preview">
                <div class="text-center">
                    <h3 style="margin-bottom: 10px;">{{ strtoupper($setting->nama_perusahaan) }}</h3>
                    <p>{{ strtoupper($setting->alamat) }}</p>
                </div>
                <br>
                <div>
                    <p style="float: left;">{{ date('d-m-Y') }}</p>
                    <p style="float: right">{{ strtoupper(auth()->user()->name) }}</p>
                </div>
                <div class="clear-both" style="clear: both;"></div>
                <p>No: {{ tambah_nol_didepan($penjualan->id_penjualan, 10) }}</p>
                <p class="text-center">===================================</p>
                
                <br>
                <table width="100%" style="border: 0;">
                    @foreach ($detail as $item)
                        <tr>
                            <td colspan="3">{{ $item->produk->nama_produk }}</td>
                        </tr>
                        <tr>
                            <td>{{ $item->jumlah }} x Rp. {{ format_uang($item->harga_jual) }}</td>
                            <td></td>
                            <td class="text-right">Rp. {{ format_uang($item->jumlah * $item->harga_jual) }}</td>
                        </tr>
                    @endforeach
                </table>
                <p class="text-center">-----------------------------------</p>
            
                <table width="100%" style="border: 0;">
                    <tr>
                        <td>Total Harga:</td>
                        <td class="text-right">Rp. {{ format_uang($penjualan->total_harga) }}</td>
                    </tr>
                    <tr>
                        <td>Total Item:</td>
                        <td class="text-right">{{ format_uang($penjualan->total_item) }} items</td>
                    </tr>
                    <tr>
                        <td>Diskon:</td>
                        <td class="text-right">{{ format_uang($penjualan->diskon) }} %</td>
                    </tr>
                    <tr>
                        <td>Total Bayar:</td>
                        <td class="text-right">Rp. {{ format_uang($penjualan->bayar) }}</td>
                    </tr>
                    <tr>
                        <td>Diterima:</td>
                        <td class="text-right">Rp. {{ format_uang($penjualan->diterima) }}</td>
                    </tr>
                    <tr>
                        <td>Kembali:</td>
                        <td class="text-right">Rp. {{ format_uang($penjualan->diterima - $penjualan->bayar) }}</td>
                    </tr>
                </table>
            
                <p class="text-center">===================================</p>
                <br>
                <p class="text-center">-----Terima Kasih-----</p>
               </div>

            </div>

            
            <div class="box-footer mb-3 mt-4 mx-4  button">
                @if ($setting->tipe_nota == 1)
                    <button type="button" class="btn btn-outline-danger mx-1" onclick="notaKecil('{{ route('transaksi.nota_kecil') }}', 'Nota Kecil')"><i class="fa-solid fa-file-invoice icon"></i> Cetak Nota</button>
                @else
                    <button type="button" class="btn btn-outline-danger mx-1" onclick="notaBesar(('{{ route('transaksi.nota_besar') }}', 'Nota Besar')"><i class="fa-solid fa-file-invoice icon"></i> Cetak Nota</button>        
                @endif
                
                <a href="{{ route('transaksi.baru') }}"  class="btn btn-outline-info"><i class="fa-solid fa-cart-shopping"></i> Transaksi Baru</a>
                <a href="" onclick="" class="btn btn-outline-warning"><i class="fa-solid fa-cart-shopping"></i> Batalkan Transaksi</a>
                <a href="{{ route('dashboard') }}"  class="btn btn-outline-success"><i class="fa-solid fa-archway"></i> Dashboard</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // tambahkan untuk delete cookie innerHeight terlebih dahulu
    document.cookie = "innerHeight=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    
    function notaKecil(url, title) {
        popupCenter(url, title, 625, 500);
    }

    function notaBesar(url, title) {
        popupCenter(url, title, 900, 675);
    }

    function popupCenter(url, title, w, h) {
        const dualScreenLeft = window.screenLeft !==  undefined ? window.screenLeft : window.screenX;
        const dualScreenTop  = window.screenTop  !==  undefined ? window.screenTop  : window.screenY;

        const width  = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        const height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

        const systemZoom = width / window.screen.availWidth;
        const left       = (width - w) / 2 / systemZoom + dualScreenLeft
        const top        = (height - h) / 2 / systemZoom + dualScreenTop
        const newWindow  = window.open(url, title, 
        `
            scrollbars=yes,
            width  = ${w / systemZoom}, 
            height = ${h / systemZoom}, 
            top    = ${top}, 
            left   = ${left}
        `
        );

        if (window.focus) newWindow.focus();
    }
</script>
@endpush