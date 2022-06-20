@extends('layouts.main')

@section('title')
Rekap 
@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('/AdminLTE-2/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endpush

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Laporan</li>
@endsection

@section('content')


<div class="row mx-3">
    <div class="col-md-12 p-3 mb-3" style="background-color: white; padding:50px;">
        <div class="box" style="padding:20px;">
            <div class="box-body">
                <div class="row">
                    <form action="{{ route('laporan.index') }}" method="get">
                        <div class="form-group row">
                            <label for="tanggal_awal" class="col-lg-2 control-label">Tanggal Awal</label>
                            <div class="col-md-3">
                                <input type="text" name="tanggal_awal" id="tanggal_awal" class="form-control flatpickr" required autofocus readonly
                                    value="{{ request('tanggal_awal') }}"
                                    style="border-radius: 0 !important;">
                                <span class="help-block with-errors"></span>
                            </div>
                            
                            <label class="mx-3" for="" class="col-md-2 col-form-label">s/d</label>
    
                            <label for="tanggal_akhir" class="col-lg-2 control-label">Tanggal Akhir</label>
                            <div class="col-md-3">
                                <input type="text" name="tanggal_akhir" id="tanggal_akhir" class="form-control flatpickr" required readonly             
                                value="{{ request('tanggal_akhir') }}"
                                style="border-radius: 0 !important;">
    
                                <span class="help-block with-errors"></span>
                            </div>

                            <button type="" class="btn btn-sm btn-flat btn-primary"><i class="fa fa-search"></i> Cari</button>
                         
                        </div>
                    </form>
                </div>

                <br>
                <h5>Laporan {{ tanggal_indonesia($tanggalAwal) }} s/d {{ tanggal_indonesia($tanggalAkhir) }}</h5>
                <br>
{{-- 
                <button onclick="ubahPeriode()" class="btn btn-primary btn-sm btn-flat" type="button"><i
                    class="fa fa-search"></i> Ubah Periode</button> --}}
                <a href="{{ route('laporan.export_pdf', [$tanggalAwal, $tanggalAkhir] ) }}" target="_blank" class="btn btn-danger btn-sm btn-flat" ><i class="bi bi-filetype-pdf"></i> Export PDF</a>

                <div class="row mt-4 mb-4">

                    <div class="box-body table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>       
                                <th width="4%" class="text-center">No</th>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">Total Pembelian</th>
                                <th class="text-center">Total Penjualan</th>
                                {{-- <th width="8%" class="text-center"></i> Aksi</th> --}}
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- @includeIf('reportpenjualan.form') --}}
@endsection

@push('scripts')
    <script src="{{ asset('/AdminLTE-2/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $('body').addClass('sidebar-collapse');

        $(".flatpickr").flatpickr({
            enableTime: false,
            dateFormat: "d-m-Y",
            autoclose: true,
            // ubahPeriode();
        });

        let table;

        $(function () {
            table = $('.table').DataTable({
                processing: true,
                responsive: true,
                autoWidth: false,
                serverSide: true,
                ajax: {
                    url: '{{ route('laporan.data', [$tanggalAwal, $tanggalAkhir]) }}',
                },          
                columns: [
                    // {data:'select_all', searchable: false, sortable: false},
                    {data:'DT_RowIndex', searchable: false, sortable: false},
                    {data:'tanggal'},
                    {data:'pembelian'},
                    {data:'penjualan'},
                    // {data:'aksi', searchable: false, sortable: false},
                ],

                bSort : false,
            });

            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true
            });

           
        });

        function ubahPeriode() {
            $('#modal-form').modal('show');
        }

        function detailData(url) {
            
        }

    
    </script>
@endpush
