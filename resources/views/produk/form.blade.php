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
                        <label for="nama_produk" class="col-md-2 col-md-offset-1 control-label">Nama</label>
                            <div class="col-md-9">
                               <input type="text" name="nama_produk" id="nama_produk" class="form-control" autofocus  placeholder="Product">
                            </div>
                    </div>
                
                    <div class="form-group row">
                        <label for="id_kategori" class="col-md-2 col-md-offset-1 control-label">Kategori</label>
                            <div class="col-md-9">
                               <select name="id_kategori" id="id_kategori" class="form-control">
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($kategori as $key => $item )
                                        <option value="{{ $item }}">{{ $key }}</option>
                                    @endforeach
                                </select>  
                            </div>
                    </div>
                
                    <div class="form-group row">
                        <label for="id_satuan" class="col-md-2 col-md-offset-1 control-label">Satuan</label>
                            <div class="col-md-9">
                               <select name="id_satuan" id="id_satuan" class="form-control" >
                                    <option value="">Pilih Satuan</option>
                                    @foreach ($satuan as $sat => $items )
                                        <option value="{{ $items }}">{{ $sat }}</option>
                                    @endforeach
                                </select>  
                            </div>
                    </div>
                
                    <div class="form-group row">
                        <label for="harga_beli" class="col-md-2 col-md-offset-1 control-label">Harga Beli</label>
                            <div class="col-md-9">
                               <input type="number" name="harga_beli" id="harga_beli" class="form-control" >
                            </div>
                    </div>

                    <div class="form-group row">
                        <label for="harga_jual" class="col-md-2 col-md-offset-1 control-label">Harga Jual</label>
                            <div class="col-md-9">
                               <input type="number" name="harga_jual" id="harga_jual" class="form-control" >
                            </div>
                    </div>

                    <div class="form-group row">
                        <label for="diskon" class="col-md-2 col-md-offset-1 control-label">Diskon</label>
                            <div class="col-md-9">
                               <input type="number" name="diskon" id="diskon" class="form-control" value="0">
                            </div>
                    </div>
                
                    <div class="form-group row">
                        <label for="stok" class="col-md-2 col-md-offset-1 control-label">Stok</label>
                            <div class="col-md-9">
                               <input type="number" name="stok" id="stok" class="form-control"  value="0">
                            </div>
                    </div>


                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-info">Simpan</button>
                </div>
            </div>
       </form>
    </div>
</div>