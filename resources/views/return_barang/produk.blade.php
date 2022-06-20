<!-- Modal -->
<div class="modal fade" class="modal-produk" id="modal-produk" tabindex="1" role="dialog" aria-labelledby="modal-produk">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content"> 
            <div class="modal-header">
                <h4 class="modal-title">Pilih Produk</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{-- <h4 class="modal-title">Pilih Produk</h4> --}}
            </div>

            <div class="modal-body">
                <table class="table table-striped table-bordered table-produk">
                    <thead>
                        <th width="6%">No</th>
                        <th width="10%">Barcode</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th width="6%">Aksi</th>
                    </thead>
                    <tbody>
                        @foreach ($supplier as $key => $item)
                            @foreach ($item->produk as $k => $produk)
                            <tr>
                                <td width="6%">{{ $k+1 }}</td>
                                <td width="10%"><span class="badge badge-info">{{ $produk->barcode }}</span></td>
                                <td>{{ $produk->nama_produk }}</td>
                                <td>{{ 'Rp. '. format_uang($produk->harga_beli) }}</td>
                                <td>{{ $produk->stok }}</td>
                                <td width="6%">
                                    <a href="#" class="btn btn-primary btn-xs btn-flat"
                                    onclick="pilihProduk('{{ $produk->id_produk }}', '{{ $produk->barcode }}') ">    
                                        <i class="fa fa-check-circle"></i>
                                        Pilih
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->