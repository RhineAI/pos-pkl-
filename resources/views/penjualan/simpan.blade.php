<!-- Modal -->
<div class="modal fade" id="modal-simpan" tabindex="-1" role="dialog" aria-labelledby="modal-simpan">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <table class="table table-striped table-bordered">
                    <thead>
                        <th width="4%">No</th>
                        <th width="8%">Tanggal</th>
                        <th width="15%">Nama Produk</th>
                        <th width="8%">Jumlah</th>
                        <th width="13%">Total Bayar</th>
                        <th width="15%">Aksi</th>
                    </thead>
                    <tbody>
                        @foreach ($produk as $key => $item)
                            <tr>
                                <td width="4%"></td>
                                <td width="8%"></td>
                                <td width="15%"></td>
                                <td width="8%"></td>
                                <td width="13%"></td>
                                <td width="15%">
                                    <a href="#" class="btn btn-success btn-xs btn-flat">
                                        <i class="fa fa-money-bill"></i>
                                        Proses
                                    </a>
                                    <a href="#" class="btn btn-danger btn-xs btn-flat">
                                        <i class="fa fa-trash"></i>
                                        Hapus
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat btn-sm" data-dismiss="modal"><i
                        class="fa fa-circle-xmark"></i> Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->