@extends('layouts.main')

@section('title')
    Transaksi Penjualan
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Transaksi Penjualan</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-body mx-3">
                <div class="alert alert-success alert-dismissible">
                    <i class="fa fa-check icon"></i>
                    Data Transaksi telah selesai.
                </div>
            </div>
            <div class="box-footer mb-3 mt-4 mx-4">
                @if ($setting->tipe_nota == 1)
                    <button type="button" class="btn btn-outline-danger mx-1" onclick="notaKecil('{{ route('transaksi.nota_kecil') }}', 'Nota Kecil')"><i class="fa-solid fa-file-invoice icon"></i> Cetak Nota</button>
                @else
                    <button type="button" class="btn btn-outline-danger mx-1" onclick="notaBesar(('{{ route('transaksi.nota_besar') }}', 'Nota Besar')"><i class="fa-solid fa-file-invoice icon"></i> Cetak Nota</button>        
                @endif
                
                <a href="{{ route('transaksi.baru') }}"  class="btn btn-outline-info"><i class="fa-solid fa-cart-shopping"></i> Transaksi Baru</a>

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