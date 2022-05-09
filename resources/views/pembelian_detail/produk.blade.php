<!-- Modal -->
<div class="modal fade" id="modal-supplier" tabindex="-1" role="dialog" aria-labelledby="modal-supplier">
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
                        <th width="6%">No</th>
                        <th>Nama Supplier</th>
                        <th>Alamat</th>
                        <th>No. Telepon</th>
                        <th width="6%">Aksi</th>
                    </thead>
                    <tbody>
                        @foreach ($supplier as $sup => $human)
                            <tr>
                                <td>{{ $sup+1 }}</td>
                                <td>{{ $human->nama }}</td>
                                <td>{{ $human->alamat }}</td>
                                <td>{{ $human->telepon }}</td>
                                <td>
                                    <a href="{{ route('pembelian.index', $human->id_supplier) }}" class="btn btn-primary btn-xs btn-flat">
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