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
                <form action="{{ route('supplier.produk') }}" method="POST" id="simpanProduct">
                    <input type="hidden" name="id_supplier" id="id_supplier"> 
                    <input type="hidden" name="id_produk">
                    <table class="table table-striped table-bordered table-produk">
                        <thead>
                            <th>
                                <input type="checkbox" name="id_produk" id="select-all"> 
                            </th>
                            <th width="6%">No</th>
                            <th>Barcode</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Stok</th>
                        </thead>
                        <tbody>
                        @foreach ($produk as $key => $item)
                            <tr>
                               
                                <td>
                                    <input type="checkbox" name="checkbox[]" id="id_produk" class="produk" value="{{ $item->id_produk }}">
                                </td>
                                <td width="6%">{{ $key+1 }}</td>
                                <td id="barcode"><span class="badge badge-info">{{ $item->barcode }}</span></td>
                                <td id="nama_produk">{{ $item->nama_produk }}</td>
                                <td id="harga_beli">{{ 'Rp. '. format_uang($item->harga_beli) }}</td>
                                <td id="stok">{{ $item->stok }}</td>
                                {{-- <td width="6%">
                                    <a href="#" class="btn btn-primary btn-xs btn-flat"
                                    onclick="pilihProduk()">    
                                        <i class="fa fa-check-circle"></i>
                                        Pilih
                                    </a>
                                </td> --}}
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat btn-sm" data-dismiss="modal"><i class="fa fa-circle-xmark"></i> Batal</button>
                    <button type="submit" name="submit" class="btn btn-primary btn-flat btn-sm"><i class="fa fa-circle-check"></i> Simpan</button>
                </div>
            </form>

        </div>
    </div>
</div>
<!-- End Modal -->
@push('script')
<script>
    function tambahkanProduk() {
        $.post('{{ route('supplier.store') }}', $('.modal-produk').serialize())
            .done(response => {
                alert('sucess');
            })
            .fail(errors => {
                alert('Tidak dapat menyimpan data');
                return;
            });
        }
    
    $('#select-all').on('click', function () {
        $(':checkbox').prop('checked', this.checked);
    });

    // $('#select-all').change(function(){

    //     if (! $('input:checkbox').is('checked')) {
    //         $('input:checkbox').attr('checked','checked');
    //     } else {
    //         $('input:checkbox').removeAttr('checked');
    //     }       
    // });
</script>
    
@endpush
