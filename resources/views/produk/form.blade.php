<!-- Modal -->
<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form">
    <div class="modal-dialog modal-lg" role="document">
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
                        <label for="nama_produk" class="col-md-2 col-md-offset-1 control-label">Nama</label>
                        <div class="col-md-10">
                            <input type="text" name="nama_produk" id="nama_produk" class="form-control" autofocus
                                required placeholder="Product">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="id_kategori" class="col-md-2 col-md-offset-1 control-label">Kategori</label>
                        <div class="col-md-10">
                            <select name="id_kategori" id="id_kategori" class="form-control" required>
                                <option value="">Pilih Kategori</option>
                                @foreach ($kategori as $key => $item )
                                <option value="{{ $item }}">{{ $key }}</option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="id_satuan" class="col-md-2 col-md-offset-1 control-label">Satuan</label>
                        <div class="col-md-10">
                            <select name="id_satuan" id="id_satuan" class="form-control" required>
                                <option value="">Pilih Satuan</option>
                                @foreach ($satuan as $sat => $items )
                                    <option value="{{ $items }}">{{ $sat }}</option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    
                    <div class="input-group mb-3 row mx-1"> 
                        <label for="harga_beli" class="col-md-2 col-md-offset-1 control-label pr-2">Harga Beli</label>
                        <div class="input-group-prepend"> 
                            <span class="input-group-text">RP.</span> 
                        </div> 
                        <input type="text" name="harga_beli" id="harga_beli" class="form-control" required placeholder="0" aria-describedby="basic-addon1">
                        <span class="help-block with-errors"></span>
                    </div>
                
                    <div class="input-group mb-3 row mx-1"> 
                        <label for="harga_jual" class="col-md-2 col-md-offset-1 control-label pr-2">Harga Jual</label>
                        <div class="input-group-prepend"> 
                            <span class="input-group-text">RP.</span> 
                        </div> 
                        <input type="text" name="harga_jual" id="harga_jual" class="form-control" required placeholder="0" aria-describedby="basic-addon1">
                        <span class="help-block with-errors"></span>
                    </div>

                    {{-- <div class="form-group row">
                        <label for="harga_jual" class="col-md-2 col-md-offset-1 control-label">Harga Jual</label>
                        <div class="col-md-10">
                            <input type="text" name="harga_jual" id="harga_jual" class="form-control" required placeholder="0">
                            {{-- <input type="hidden" name="harga_beli_ins" id="harga_jual_ins" class="form-control"> --}}
                            {{-- <span class="help-block with-errors"></span>
                        </div>
                    </div> --}}

                    {{-- <div class="form-group row">
                        <label for="diskon" class="col-md-2 col-md-offset-1 control-label">Diskon</label>
                        <div class="col-md-10">
                            <input type="number" name="diskon" id="diskon" class="form-control" value="0" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div> --}}

                    <div class="form-group row">
                        <label for="stok" class="col-md-2 col-md-offset-1 control-label">Stok</label>
                        <div class="col-md-10">
                            <input type="number" name="stok" id="stok" class="form-control" value="0" required>
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