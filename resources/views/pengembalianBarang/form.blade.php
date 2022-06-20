<!-- Modal -->
<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form">
    <div class="modal-dialog modal-md" role="document">
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

                    {{-- <div class="form-group row">
                        <label for="id_produk" class="col-md-3 col-md-offset-1 control-label">Invoice</label>
                        <div class="col-md-9">
                            <select name="id_produk" id="id_produk" class="form-control" required>
                                <option value="">Pilih Invoice</option>
                                @foreach ($pembelian as $key => $item )
                                    <option value="{{ $item }}">{{ $key }}</option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div> --}}

                    
                    <table class="table table-striped table-bordered table-supplier">
                        <thead>
                            <th width="6%">No</th>
                            <th>Tanggal</th>
                            <th>Invoice</th>
                            <th>Supplier</th>
                            <th width="6%">Aksi</th>
                        </thead>
                        <tbody>
                            @foreach ($pembelian as $key => $item)
                                <tr>
                                    <td width="6%">{{ $key+1 }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>{{ $item->kode_pembelian }}</td>
                                    <td>{{ $item->id_supplier }}</td>
                                    
                                    <td width="5%">
                                        {{-- <a href="{{ route('pembelian.create', $item->id_supplier) }}" class="btn btn-primary btn-xs btn-flat">
                                            <i class="fa fa-check-circle"></i>
                                            Pilih
                                        </a> --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    


                </div>
                {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat btn-sm" data-dismiss="modal"><i
                            class="fa fa-circle-xmark"></i> Batal</button>
                    <button type="submit" class="btn btn-primary btn-flat btn-sm"><i class="fa fa-circle-check"></i>
                        Simpan</button>
                </div> --}}
            </div>
        </form>
    </div>
</div>