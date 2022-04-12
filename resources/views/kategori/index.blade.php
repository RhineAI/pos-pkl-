@extends('layouts.main')

@section('title')
Dashboard
@endsection

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<div class="row mx-3" style="background-color: white">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <button onclick="addForm()" class="btn btn-success btn-flat mx-2 my-3"><i class="fa fa-plus-circle"></i> Tambah</button>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-stiped table-bordered">
                        <thead>
                            <th width="5%">No</th>
                            <th>Kategori</th>
                            <th width="15%">Aksi</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@includeIf('kategori.form')
@endsection

@push('scripts')
    <script>
        let table;

        $function () {
            table = $('.table').DataTable({
                processing: true,
                autoWidth: false,
                // ajax: {
                //     url: '{{ route('kategori.data') }}',
                // }
            });
        };

        function addForm() {
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text('Tambah Kategori');
        }
    </script>
@endpush