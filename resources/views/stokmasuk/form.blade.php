<!-- Modal -->
<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form">
    <div class="modal-dialog" role="document">
        <form action="" method="post" class="form-horizontal">
            @csrf
            @method('post')

            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group row">
                        <label for="id_produk" class="col-md-3 col-md-offset-1 control-label">Produk</label>
                        <div class="col-md-9">
                            <select name="id_produk" id="id_produk" class="form-control" required>
                                <option value="">Pilih Produk</option>
                                @foreach ($produk as $key => $item )
                                    <option value="{{ $item }}">{{ $key }}</option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    {{-- <div class="form-group row">
                        <label for="id_produk" class="col-md-3">Barcode</label>
                        <div class="col-md-9">
                            <div class="input-group">
                                <input type="text" class="form-control" name="id_produk" id="id_produk">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-info btn-flat btn-search" data-toggle="modal"
                                        data-target=".modal-produk"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </div>
                    </div> --}}


                     <div class="form-group row">
                        <label for="jumlah" class="col-md-3">Jumlah</label>
                        <div class="col-md-9">
                            <div class="input-group">
                                <input type="number" name="jumlah" id="jumlah" class="form-control" value="0" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="keterangan" class="col-md-3 col-form-label">Keterangan</label>
                        <div class="col-md-9">
                            <select name="keterangan" id="keterangan" class="form-control">
                                <option>Tambah Keterangan</option>
                                <option value="Bonus Barang">Bonus Barang</option>
                                <option value="Beli dari Lain">Beli dari Lain</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat btn-sm" data-dismiss="modal"><i
                            class="fa fa-circle-xmark"></i> Batal</button>
                    <button type="submit" class="btn btn-primary btn-flat btn-sm"><i class="fa fa-circle-check"></i>
                        Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>