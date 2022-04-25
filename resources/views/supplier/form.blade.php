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
                        <label for="nama" class="col-md-2 col-md-offset-1 control-label"><h5 class="my-2">Nama</h5></label>
                            <div class="col-md-10">
                               <input type="text" name="nama" id="nama" class="form-control" required autofocus>
                            </div>
                    </div>
                      
                    <div class="form-group row">
                        <label for="alamat" class="col-md-2 col-md-offset-1 control-label"><h5 class="my-2">Alamat</h5></label>
                            <div class="col-md-10">
                               <input type="text" name="alamat" id="alamat" class="form-control" required autofocus>
                            </div>
                    </div>

                    <div class="form-group row">
                        <label for="telepon" class="col-md-2 col-md-offset-1 control-label"><h5 class="my-2">Telepon</h5></label>
                            <div class="col-md-10">
                               <input type="text" name="telepon" id="telepon" class="form-control" required autofocus>
                            </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
       </form>
    </div>
</div>