<!-- Modal1 -->
<div class="modal fade" id="modal-bayar" tabindex="-1" role="dialog" aria-labelledby="modal-bayar">
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
                        <label for="" class="col-md-3">Total Bayar</label>
                        <div class="col-md-9">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">Rp.</span>
                                <input type="text" class="form-control" name="" id="">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-md-3">Diskon</label>
                        <div class="col-md-9">
                            <div class="input-group">
                                <input type="number" name="" id="" class="form-control" value="0" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-md-3">Jumlah Bayar</label>
                        <div class="col-md-9">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">Rp.</span>
                                <input type="text" class="form-control" name="" id="">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-md-3">Kembalian</label>
                        <div class="col-md-9">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">Rp.</span>
                                <input type="text" class="form-control" name="" id="">
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat btn-sm" data-dismiss="modal"><i
                            class="fa fa-circle-xmark"></i> Batal</button>
                    <button type="button" onclick="" class="btn btn-sm btn-flat btn-success btn-flat"><i
                        class="fa fa-money-bill"></i>
                    Bayar</button>
                </div>
            </div>
        </form>
    </div>
</div>
{{-- End Modal1 --}}