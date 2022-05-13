<!-- Modal1 -->
<div class="modal fade" id="modal-tambah" tabindex="-1" role="dialog" aria-labelledby="modal-tambah">
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
                        <label for="" class="col-md-3 col-form-label">Tanggal</label>
                        <div class="col-md-9">
                            <div class="input-group date">
                                <input type="text" class="form-control datepicker" autocomplete="off" name="date"
                                    id="date" data-provide="datepicker" value="">
                                <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-md-3">Barcode</label>
                        <div class="col-md-9">
                            <div class="input-group">
                                <input type="text" class="form-control" name="barcode" id="">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-info btn-flat btn-search" data-toggle="modal"
                                        data-target="#modal-produk"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="" class="col-md-3">Nama Produk</label>
                        <div class="col-md-9">
                            <div class="input-group">
                                <input type="text" class="form-control" name="nama_produk" id="">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-md-3">Harga Beli</label>
                        <div class="col-md-9">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">Rp.</span>
                                <input type="text" class="form-control" name="harga_beli" id="">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-md-3">Harga Jual</label>
                        <div class="col-md-9">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">Rp.</span>
                                <input type="text" class="form-control" name="harga_jual" id="">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="stok" class="col-md-3">Stok</label>
                        <div class="col-md-9">
                            <div class="input-group">
                                <input type="number" name="stok" id="stok" class="form-control" value="0" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-md-3 col-form-label">Keterangan</label>
                        <div class="col-md-9">
                            <select name="" id="" class="form-control">
                                <option>Tambah Keterangan</option>
                                <option value="Hilang">Hilang</option>
                                <option value="Rusak">Rusak</option>
                                <option value="Kadaluarsa">Kadaluarsa</option>
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
{{-- End Modal1 --}}

<!-- Modal2 -->
<div class="modal fade" id="modal-produk" tabindex="-1" role="dialog" aria-labelledby="modal-produk">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Pilih Produk</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <table class="table table-striped table-bordered">
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
                                <a href="#" class="btn btn-primary btn-xs btn-flat">
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
<!-- End Modal2 -->