<!-- Modal -->
<div class="modal fade" class="modal-produk" id="modal-produk" tabindex="1" role="dialog" aria-labelledby="modal-produk">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content"> 
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{-- <h4 class="modal-title">Pilih Produk</h4> --}}
            </div>

            <div class="modal-body">
                <table class="table table-striped table-bordered table-produk">
                    <thead>
                        <th width="6%">No</th>
                        <th>Barcode</th>
                        <th>Nama</th>
                        <th>Harga Beli</th>
                        <th width="6%">Aksi</th>
                    </thead>
                    <tbody>
                        @foreach ($produk as $key => $item)
                            <tr>
                                <td width="6%">{{ $key+1 }}</td>
                                <td><span class="badge badge-info">{{ $item->barcode }}</span></td>
                                <td>{{ $item->nama_produk }}</td>
                                <td>{{ $item->harga_beli }}</td>
                                <td width="6%">
                                    <a href="#" class="btn btn-primary btn-xs btn-flat"
                                    onclick="pilihProduk('{{ $item->id_produk }}', '{{ $item->barcode }}') ">    
                                        <i class="fa fa-check-circle"></i>
                                        Pilih
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->