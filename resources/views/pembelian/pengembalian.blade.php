<!-- Modal -->
<div class="modal fade" id="form-return" tabindex="-1" role="dialog" aria-labelledby="modal-supplier">
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
                        <label for="jumlah" class="col-md-3 col-md-offset-1 control-label">Jumlah</label>
                        <div class="col-md-9">
                            <input type="number" name="jumlah" id="jumlah" class="form-control" autofocus required placeholder="0">
                            <input type="hidden" class="form-control" id="maxStokHidden">
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
<!-- End Modal -->