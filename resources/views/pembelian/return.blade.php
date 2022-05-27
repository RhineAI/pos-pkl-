<!-- Modal -->
<div class="modal fade" id="modal-return" tabindex="-1" role="dialog" aria-labelledby="modal-supplier">
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
                     
                    <table class="table table-striped table-bordered table-return">
                        <thead>
                            <th width="4%">No</th>
                            <th class="text-center">Barcode</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Harga</th>
                            <th class="text-center">Jumlah</th>                              
                            <th class="text-center">Return</th>                              
                            <th class="text-center">Subtotal</th>
                            <th class="text-center">Aksi</th>
                            {{-- <th class="text-center">Jumlah Kembali</th> --}}
                        </thead>
                      
                           
                    
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
<!-- End Modal -->

<script>
   
</script>