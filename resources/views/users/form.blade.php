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
                        <label for="" class="col-md-2 col-md-offset-1 control-label">Nama</label>
                        <div class="col-md-10">
                            <input type="text" name="" id="" class="form-control" required autofocus>
                        </div>
                        <label for="" class="col-md-2 col-md-offset-1 control-label">Email</label>
                        <div class="col-md-10">
                            <input type="text" name="" id="" class="form-control" required autofocus>
                        </div>
                        <label for="" class="col-md-2 col-md-offset-1 control-label">Password</label>
                        <div class="col-md-10">
                            <input type="text" name="" id="" class="form-control" required autofocus>
                        </div>
                        <label for="" class="col-md-2 col-md-offset-1 control-label">Posisi</label>
                        <div class="col-md-10">
                            <input type="text" name="" id="" class="form-control" required autofocus>
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