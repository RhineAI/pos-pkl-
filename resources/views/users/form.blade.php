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
                        <label for="name" class="col-md-3 col-md-offset-1 control-label">Nama </label>
                        <div class="col-md-9">
                            <input type="text" name="name" id="name" class="form-control" autofocus placeholder="ex. Rin" minlength="1">
                        </div>
                        <span class="help-block with-errors"></span>
                    </div>

                    <div class="form-group row">
                        <label for="username" class="col-md-3 col-md-offset-1 control-label">Username </label>
                        <div class="col-md-9">
                            <input type="text" name="username" id="username" class="form-control" minlength="1" maxlength="15" placeholder="Username Maximum 15 characters" >
                        </div>
                        <span class="help-block with-errors"></span>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-3 col-md-offset-1 control-label">Email </label>
                        <div class="col-md-9">
                            <input type="email" name="email" id="email" class="form-control" placeholder="ex. 123xy@gmail.com" >
                        </div>
                        <span class="help-block with-errors"></span>
                    </div>

                    <div class="form-group row">
                        <label for="Posisi" class="col-md-3 col-md-offset-1 control-label">Posisi</label>
                        <div class="col-md-5">
                            <select name="level" class="form-control" id="Posisi" required>
                                <option selected>Pilih Posisi</option>
                                <option value="1">Admin</option>
                                <option value="2">Kasir</option>
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-3 col-lg-offset-1 control-label">Password</label>
                        <div class="col-md-9">
                            <input type="password" name="password" id="password" class="form-control" 
                            required
                            minlength="6">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password_confirmation" class="col-md-3 col-lg-offset-1 control-label">Konfirmasi Password</label>
                        <div class="col-md-9">
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" 
                                required
                                data-match="#password">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    {{-- <div class="form-group row">
                        <label for="foto" class="col-md-3 col-md-offset-1 control-label">Foto </label>
                        <div class="col-md-9">
                            <input type="file" name="foto" id="foto" class="form-control" >
                        </div>
                        <span class="help-block with-errors"></span>
                    </div>  --}}

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat btn-sm" data-dismiss="modal"><i class="fa fa-circle-xmark"></i> Batal</button>
                    <button type="submit" class="btn btn-primary btn-flat btn-sm"><i class="fa fa-circle-check"></i> Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>