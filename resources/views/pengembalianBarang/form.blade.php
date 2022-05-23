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

                    <div class="form-group row">
                        <label for="jumlah" class="col-md-3 col-md-offset-1 control-label">Jumlah</label>
                        <div class="col-md-9">
                            <input type="number" name="jumlah" id="jumlah" class="form-control" autofocus
                                required placeholder="0">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="id_supplier" class="col-md-3 col-md-offset-1 control-label">Supplier</label>
                        <div class="col-md-9">
                            <select name="id_supplier" id="id_supplier" class="form-control" required>
                                <option value="">Pilih Supplier</option>
                                @foreach ($supplier as $key => $item )
                                    <option value="{{ $item }}">{{ $key }}</option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="keterangan" class="col-md-3 col-md-offset-1 control-label">Keterangan</label>
                        <div class="col-md-9">
                            <input type="text" name="keterangan" id="keterangan" class="form-control" autofocus
                                required placeholder="">
                            <span class="help-block with-errors"></span>
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