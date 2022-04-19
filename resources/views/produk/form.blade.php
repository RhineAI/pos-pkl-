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
                        <label for="nama_produk" class="col-md-2 col-md-offset-1 control-label">Produk</label>
                            <div class="col-md-9">
                               <input type="text" name="nama_produk" id="nama_produk" class="form-control" required>
                               {{-- @error('nama_kategori') is-invalid @enderror" required autofocus value="{{ old('nama_kategori') }}" --}}
                               {{-- @error('nama_kategori')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                               @enderror --}}
                            </div>
                    </div>
                </div>

                <div class="modal-body">
                    <div class="form-group row">
                        <label for="nama_produk" class="col-md-2 col-md-offset-1 control-label">Kategori</label>
                            <div class="col-md-9">
                               <select name="id_kategori" id="id_kategori" class="form-control" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($kategori as $key => $item )
                                        <option value="{{ $key }}">{{ $item }}</option>
                                    @endforeach
                                </select>  
                            </div>
                    </div>
                </div>

                <div class="modal-body">
                    <div class="form-group row">
                        <label for="nama_produk" class="col-md-2 col-md-offset-1 control-label">Satuan</label>
                            <div class="col-md-9">
                               <select name="id_satuan" id="id_satuan" class="form-control" required>
                                    <option value="">Pilih Satuan</option>
                                    @foreach ($satuan as $sat => $items )
                                        <option value="{{ $sat }}">{{ $items }}</option>
                                    @endforeach
                                </select>  
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